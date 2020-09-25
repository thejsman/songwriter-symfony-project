<?php

namespace AppBundle\Action\User;

use AppBundle\Entity\User;
use AppBundle\Service\UpdateTokenSender\Exception\UnknownTransportException;
use Requestum\ApiBundle\Action\EntityAction;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class RequestUpdateTokenAction
 */
class RequestUpdateTokenAction extends EntityAction
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     *
     * @throws \Exception
     */
    public function executeAction(Request $request)
    {
        try {
            /** @var User $user */
            $user = $this->getEntity($request, 'email');
        } catch (NotFoundHttpException $exception) {
            throw $this->createNotFoundException('There is no account associated with this email or a server error has occurred. Please make sure that the email you entered is correct and try again. Otherwise, if the problem persists, please contact us at support@songwriterprofessional.com');
        }

        // return 403 for users who was logged in with external service (e.g. facebook)
        if ($user->getExternalService() != null) {
             throw new AccessDeniedHttpException($user->getExternalService());
        }


        $form = $this->get('form.factory')->createNamedBuilder('')
            ->add('transport')
            ->setMethod(Request::METHOD_POST)
            ->getForm()
            ->handleRequest($request)
        ;

        if (!$form->isSubmitted()) {
                throw new BadRequestHttpException('Wrong request');
        }

        try {
            $user->setConfirmationToken($this->generateToken());
            $this->get('app.service.update_token_sender')->send($form->get('transport')->getData(), $user);
            $this->getDoctrine()->getManager()->flush();

            return $this->handleResponse(null, Response::HTTP_NO_CONTENT);
        } catch (UnknownTransportException $exception) {
            $form->get('transport')->addError(
                new FormError(
                    'Unknown transport',
                    null,
                    [],
                    null,
                    'error.constraint.unknown_transport'
                )
            );

            return $this->handleResponse($form, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @return string
     */
    private function generateToken()
    {
        return 't_'.rtrim(strtr(hash('sha256', rand()), '+/', '-_'), '=');
    }
}
