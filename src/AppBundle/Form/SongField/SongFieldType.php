<?php

namespace AppBundle\Form\SongField;

use AppBundle\Entity\File;
use AppBundle\Entity\SongField;
use AppBundle\Entity\SongFieldTypes;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SongFieldType.
 */
class SongFieldType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externalId')
            ->add('type', ChoiceType::class, [
                'choices' => SongFieldTypes::TYPES,
            ])
            ->add('chords', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('metronome', MetronomeType::class)
            ->add('text')
            ->add('audio', EntityType::class, [
                'class' => File::class,
                'multiple' => true,
                'by_reference' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SongField::class,
            'allow_extra_fields' => true,
        ]);
    }
}
