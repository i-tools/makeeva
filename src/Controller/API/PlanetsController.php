<?php

namespace App\Controller\API;

use App\Entity\Planet;
use App\Exception\PlanetNotFoundException;
use App\Interfaces\PageInterface;
use App\Interfaces\PlanetInterface;
use App\Repository\PlanetRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanetsController extends AbstractController
{
    #[Route('/api/planet/list', name: 'api_planets_list', methods: ['GET', 'HEAD'])]
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
            ];
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planets' => $result
        ]);
    }

    #[Route('/api/planet/{id}', name: 'api_get_planet_by_id', methods: ['GET', 'HEAD'])]
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
