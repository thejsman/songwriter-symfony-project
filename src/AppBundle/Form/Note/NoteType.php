<?php

namespace AppBundle\Form\Note;

use AppBundle\Entity\Note;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NoteType
 */
class NoteType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externalId')
            ->add('author')
            ->add('coAuthor')
            ->add('started')
            ->add('finished')
            ->add('publisher')
            ->add('key')
            ->add('BMP')
            ->add('style')
            ->add('notes')
            ->add('tempo');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'allow_extra_fields' => true,
        ]);
    }
}
