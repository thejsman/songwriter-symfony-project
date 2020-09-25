<?php

namespace AppBundle\Serializer\Song;

use AppBundle\Entity\SongField;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\NormalizationAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SongFieldNormalizer.
 */
class SongFieldNormalizer implements NormalizerInterface, NormalizationAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        /** @var SongField $object */
        $values = $object->getAudio()->getValues();

        $object->setAudio(new ArrayCollection($values));

        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof SongField;
    }
}
