<?php

namespace AppBundle\Form\Song;

use AppBundle\Entity\Folder;
use AppBundle\Entity\Song;
use AppBundle\EventListener\Form\SongFolderListener;
use AppBundle\Form\ApiCollectionType;
use AppBundle\Form\Note\NoteType;
use AppBundle\Form\SongField\SongFieldType;
use AppBundle\Repository\FolderRepository;
use Requestum\ApiBundle\Form\Type\AbstractApiType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SongType
 */
class SongType extends AbstractApiType
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
            ->add('deviceId', TextType::class, [
                'by_reference' => false,
            ])
            ->add('deviceModel', TextType::class, [
                'by_reference' => false,
            ])
            ->add('orderNumber')
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'query_builder' => function (FolderRepository $userRepository) use ($options) {
                    return $userRepository
                        ->createQueryBuilder('folder')
                        ->join('folder.user', 'user')
                        ->where('user = :user')
                        ->setParameter('user', $options['user']);
                },
            ])
            ->add('fields', ApiCollectionType::class, [
                'entry_type' => SongFieldType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('note', NoteType::class)
            ->add('ideas', ApiCollectionType::class, [
                'entry_type' => SongIdeas::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, [new SongFolderListener($options['em'], $options['user']), 'preSubmit']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);

        $resolver->setRequired(['user', 'em']);
    }
}
