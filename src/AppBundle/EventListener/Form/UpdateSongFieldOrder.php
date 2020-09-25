<?php

namespace AppBundle\EventListener\Form;

use AppBundle\Entity\SongField;
use Symfony\Component\Form\FormEvent;

/**
 * Class UpdateSongFieldOrder
 */
class UpdateSongFieldOrder
{
    /**
     * @param FormEvent $event
     */
    public function postSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        foreach ($form->get('fieldsIdOrdered')->getData() as $orderNumber => $fieldId) {
            /** @var SongField $songField */
            foreach ($data->getFields() as $songField) {
                if ($songField->getId() === (int) $fieldId) {
                    $songField->getOrder()->setWeight($orderNumber + 1);
                }
            }
        }
    }
}
