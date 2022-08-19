<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\GalleryEntity;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('imageName', FileUploadType::class, [
//                'basePath' => '',
                'upload_dir' => '',
                'attr' => [
                    'class' => 'field-image'
                ],
                'row_attr' => [
                    'class' => 'field-image'
                ],
//                'uploadedFileNamePattern' => '[name].[extension]'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GalleryEntity::class,
        ]);
    }
}
