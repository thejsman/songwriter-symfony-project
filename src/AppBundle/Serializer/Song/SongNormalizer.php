<?php

namespace AppBundle\Serializer\Song;

use AppBundle\Entity\Song;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Encoder\NormalizationAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SongNormalizer.
 */
class SongNormalizer implements NormalizerInterface, NormalizationAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        /**
         * @var Song $object
         * @var Collection $fields
         * @var Collection $ideas
         */
        $fields = $object->getFields()->getValues();
        $ideas = $object->getIdeas()->getValues();

        $object->setFields(new ArrayCollection($fields));
        $object->setIdeas(new ArrayCollection($ideas));

        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Song;
    }
}
