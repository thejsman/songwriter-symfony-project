<?php

namespace AppBundle\Action;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UpdateAction
 */
class UpdateAction extends \Requestum\ApiBundle\Action\UpdateAction
{

    /**
     * {@inheritdoc}
     */
    public function processEntity(Request $request, $entity)
    {
        $form = $this->buildForm($entity, $this->getFormOptions($request));
        $form->handleRequest($request);

        if (!$this->isNeedToUpdate($form, $entity)) {
            return $this->handleResponse($this->options['return_entity'] ? $entity : null, $this->options['success_status_code']);
        }

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException('Wrong request');
        }

        if ($form->isValid()) {
            $this->checkAccess($entity);

            try {
                $this->beforeSave($request, $entity, $form);
                $this->processSubmit($request, $entity, $form);
                $this->afterSave($request, $entity, $form);

                return $this->handleResponse($this->options['return_entity'] ? $entity : null, $this->options['success_status_code']);
            } catch (FormValidationException $exception) {
                foreach ($exception->getErrors() as $path => $errors) {
                    $targetForm = is_string($path) ? $this->get('property_accessor')->getValue($form, $path) : $form;
                    foreach ((array) $errors as $error) {
                        $targetForm->addError($error);
                    }
                }
            }
        }

        return $this->handleResponse($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'http_method' => Request::METHOD_POST,
            'access_attribute' => 'update',
        ]);
    }

    /**
     * @param Form  $form
     * @param Mixed $entity
     *
     * @return bool
     */
    protected function isNeedToUpdate(Form $form, $entity)
    {
        if (!$form->get('updatedAt')->getData()) {
            throw new BadRequestHttpException('Missing required field "updatedAt"');
        }

        return $entity->getUpdatedAt() <= $form->get('updatedAt')->getData();
    }
}
