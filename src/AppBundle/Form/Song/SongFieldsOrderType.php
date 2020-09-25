<?php

namespace AppBundle\Form\Song;

use AppBundle\Constraints\SongFieldsOrderValidation;
use AppBundle\Entity\Song;
use AppBundle\EventListener\Form\UpdateSongFieldOrder;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;

/**
 * Class SongFieldsOrder
 */
class SongFieldsOrderType extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fieldsIdOrdered', CollectionType::class, [
                'entry_type' => NumberType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => new Callback([new SongFieldsOrderValidation(), 'checkSongFieldIds']),
                'mapped' => false,
            ]);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [new UpdateSongFieldOrder(), 'postSubmit']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);
    }
}
