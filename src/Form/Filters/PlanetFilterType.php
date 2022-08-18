<?php

declare(strict_types=1);

namespace App\Form\Filters;

use App\Entity\Planet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanetFilterType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $arrayChoices = [];

        /** @var Planet $planetsList */
        $planetsList = $this->em->getRepository(Planet::class)->findAll();

        foreach ($planetsList as $planet) {
            $arrayChoices[$planet->getTitle()] = $planet->getId();
        }

        $resolver->setDefaults([
            'choices' => $arrayChoices,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
