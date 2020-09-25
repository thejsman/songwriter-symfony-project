<?php

namespace AppBundle\Form\Song;

use AppBundle\Entity\Idea;
use AppBundle\Entity\IdeaTypes;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SongIdeas.
 */
class SongIdeas extends AbstractApiType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('externalId')
            ->add('type', ChoiceType::class, [
                'choices' => IdeaTypes::TYPES,
            ])
            ->add('category')
            ->add('text');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
            'allow_extra_fields' => true,
        ]);
    }
}
