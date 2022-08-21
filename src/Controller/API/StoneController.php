<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\GalleryEntity;
use App\Entity\Planet;
use App\Interfaces\GalleryEntityInterface;
use App\Interfaces\PlanetInterface;
use App\Interfaces\StoneInterface;
use App\Repository\PlanetRepository;
use App\Repository\StoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoneController extends AbstractController
{
    #[Route('/api/stones/list', name: 'api_stones_list', methods: ['GET', 'HEAD'])]
    public function stonesList(StoneRepository $stoneRepository): JsonResponse
    {
        $stonesResult = [];
        $galleries = null;
        $stones = $stoneRepository->findAll();

        foreach ($stones as $stone) {
            if (!$stone->isPublished()) continue;
            $itemResult = [
                'id' => $stone->getId(),
                'title' => $stone->getTitle(),
                'image' => ($stone->getImageName()) ? $this->getParameter('app.stones.images.uri') . $stone->getImageName() : null,
                'slug' => $stone->getSlug(),
                'description' => $stone->getDescription(),
                'planet' => null,
            ];
            /** @var PlanetInterface $planet */
            $planet = $stone->getPlanet();
            if ($planet instanceof PlanetInterface) {
                $itemResult['planet'] = [
                    'id' => $planet->getId(),
                    'title' => $planet->getTitle(),
                ];
            }

            $stonesResult[] = $itemResult;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planets' => $stonesResult
        ]);
    }

    #[Route('/api/stones/{id}', name: 'api_get_stone_by_id', methods: ['GET', 'HEAD'])]
    public function getStoneById(StoneRepository $stoneRepository, int $id): JsonResponse
    {
        /** @var StoneInterface $planet */
        $stone = $stoneRepository->findOneBy(['id' => $id]);

        $result = [
            'id' => $stone->getId(),
            'title' => $stone->getTitle(),
            'image' => ($stone->getImageName()) ? $this->getParameter('app.stones.images.uri') . $stone->getImageName() : null,
            'slug' => $stone->getSlug(),
            'description' => $stone->getDescription(),
            "content" => $stone->getContent()
        ];

        /** @var PlanetInterface $planet */
        $planet = $stone->getPlanet();
        if ($planet instanceof PlanetInterface) {
            $result['planet'] = [
                'id' => $planet->getId(),
                'title' => $planet->getTitle(),
                'api_link' => '/api/planets/' . $planet->getId()
            ];
        }

        if ($gallery = $stone->getGallery()) {
            /** @var GalleryEntityInterface $photo */
            foreach ($gallery as $photo) {
                $result['gallery'][] = [
                    'title' => $photo->getImageName(),
                    'image' => $this->getParameter('app.stones.images.uri') . '/' . $photo->getImageName(),
                ];
            }
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planet' => $result
        ]);
    }
}
