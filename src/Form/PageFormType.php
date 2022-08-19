<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Page;
use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Translation\t;

class PageFormType extends AbstractType
{
    private PlanetRepository $planetRepository;

    public function __construct(PlanetRepository $planetRepository)
    {
        $this->planetRepository = $planetRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $planetsChoice = [];
        $planets = $this->planetRepository->findAll();
        foreach ($planets as $planet) {
            $planetsChoice[$planet->getTitle()] = $planet->getId();
        }
        $builder
            ->add('title', TextType::class, [
                'label' => t('Title', [], 'admin.sections'),
            ])
            ->add('planet', ChoiceType::class, [
                'label' => t('Planet', [], 'admin.sections'),
                'choices' => $planetsChoice
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
