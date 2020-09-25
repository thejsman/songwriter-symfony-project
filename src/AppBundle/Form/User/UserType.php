<?php

namespace AppBundle\Form\User;

use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserType.
 */
class UserType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('plainPassword')
            ->add('artistName')
            ->add('primaryGenre')
            ->add('secondaryGenre')
            ->add('descriptions')
            ->add('purchaseDate', ReceiptFieldType::class);
    }
}
