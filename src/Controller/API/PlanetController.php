<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanetController extends AbstractController
{
    #[Route('/api/planets/list', name: 'api_planets_list', methods: ['GET', 'HEAD'])]
    public function planetsList(PlanetRepository $planetRepository): JsonResponse
    {
        $result = [];
        $planets = $planetRepository->findAll();

        foreach ($planets as $planet) {
            $result[] = [
                'id' => $planet->getId(),
                'title' => $planet->getTitle(),
                'image' => ($planet->getImageName()) ? $this->getParameter('app.planets.images.uri') . $planet->getImageName() : null,
                'slug' => $planet->getSlug(),
                'description' => $planet->getDescription(),
                'api_link' => '/api/planets/' . $planet->getId()
            ];
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planets' => $result
        ]);
    }

    #[Route('/api/planets/{id}', name: 'api_get_planet_by_id', methods: ['GET', 'HEAD'])]
    public function getPlanetById(PlanetRepository $planetRepository, int $id): JsonResponse
    {
        /** @var Planet $planet */
        $planet = $planetRepository->findOneBy(['id' => $id]);

        $result = [
            'id' => $planet->getId(),
            'title' => $planet->getTitle(),
            'image' => ($planet->getImageName()) ? $this->getParameter('app.planets.images.uri') . $planet->getImageName() : null,
            'slug' => $planet->getSlug(),
            'description' => $planet->getDescription(),
            "content" => $planet->getContent()
        ];

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planet' => $result
        ]);
    }
}
