<?php

namespace AppBundle\Form\Folder;

use AppBundle\Entity\Folder;
use AppBundle\Entity\User;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FolderType.
 */
class FolderType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', NumberType::class, [
                'mapped' => false,
            ])
            ->add('externalId')
            ->add('updatedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'mapped' => false,
            ])
            ->add('name')
            ->add('user');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Folder::class,
        ]);
    }
}
