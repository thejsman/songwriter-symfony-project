<?php

namespace AppBundle\Form\SongField;

use AppBundle\Entity\Metronome;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MetronomeType
 */
class MetronomeType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externalId')
            ->add('tact')
            ->add('firstPart')
            ->add('secondPart');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Metronome::class,
            'allow_extra_fields' => true,
        ]);
    }
}
