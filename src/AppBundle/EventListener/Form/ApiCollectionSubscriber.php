<?php

namespace AppBundle\EventListener\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ApiCollectionSubscriber.
 */
class ApiCollectionSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => ['preSubmit', 100],
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $restoredData = [];
        $newData = [];

        $submittedCollection = $event->getData();
        $persistentCollection = $event->getForm()->getData()->toArray();

        if (empty($persistentCollection)) {
            return;
        }

        sort($submittedCollection);
        sort($persistentCollection);

        $submittedCollection = array_filter($submittedCollection, function ($item) use (&$newData) {
            if ($isNewItem = empty($item['id']) || -1 === (int) $item['id']) {
                $newData[] = $item;

                return !$isNewItem;
            }

            return !$isNewItem;
        });

        foreach ($submittedCollection as $i => $submittedItem) {
            foreach ($persistentCollection as $j => $persistentItem) {
                if ($submittedItem['id'] === $accessor->getValue($persistentItem, 'id')) {
                    $restoredData[$j] = $submittedItem;
                }
            }
        }

        foreach ($newData as $item) {
            $restoredData[] = $item;
        }

        $event->setData($restoredData);
    }
}
