<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\User\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 */
class UserController extends BaseController
{

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetPasswordAction(Request $request)
    {
        if (!$request->get('token')) {
            throw new NotFoundHttpException('The link has expired, please request another password reset via the app.');
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByConfirmationToken($request->get('token'));

        if (!$user) {
            throw new NotFoundHttpException('The link has expired, please request another password reset via the app.');
        }

        $form = $this->createForm(PasswordType::class, $user);


        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->render('@App/User/reset-password.html.twig', [
                'changed' => true
            ]);

        }

        return $this->render('@App/User/reset-password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
