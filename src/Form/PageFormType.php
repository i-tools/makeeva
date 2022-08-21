<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Page;
use App\Entity\Planet;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Translation\t;

class PageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => t('Title', [], 'admin.sections'),
            ])
            ->add('planet', EntityType::class, [
                'class' => Planet::class,
                'label' => t('Planet', [], 'admin.sections'),
            ])
            ->add('content', CKEditorType::class, [
                'label' => t('Content', [], 'admin.sections'),
                'attr' => [
                    'class' => 'ckeditor'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
