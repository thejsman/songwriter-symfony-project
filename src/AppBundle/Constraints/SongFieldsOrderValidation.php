<?php

namespace AppBundle\Constraints;

use AppBundle\Entity\Song;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class SongFieldsOrderValidation
 */
class SongFieldsOrderValidation
{
    /**
     * @param array                     $value
     * @param ExecutionContextInterface $context
     */
    public function checkSongFieldIds(array $value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();

        /** @var Song $data */
        $data = $form->getData();

        if (count($value) !== $data->getFields()->count()) {
            $context
                ->buildViolation('Count items is not valid')
                ->addViolation();

            return;
        }

        foreach ($data->getFields() as $songField) {
            if (!in_array($songField->getId(), $value)) {
                $context
                    ->buildViolation('Field id is not valid')
                    ->addViolation();

                return;
            }
        }
    }
}
