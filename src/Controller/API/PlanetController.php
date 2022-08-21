<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\Planet;
use App\Interfaces\GalleryEntityInterface;
use App\Interfaces\StoneInterface;
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
                'image' => ($planet->getImageName()) ? $this->getParameter('app.planets.images.uri').$planet->getImageName() : null,
                'slug' => $planet->getSlug(),
                'description' => $planet->getDescription(),
                'api_link' => '/api/planets/'.$planet->getId(),
            ];
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planets' => $result,
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
            'image' => ($planet->getImageName()) ? $this->getParameter('app.planets.images.uri').$planet->getImageName() : null,
            'slug' => $planet->getSlug(),
            'description' => $planet->getDescription(),
            'content' => $planet->getContent(),
        ];

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planet' => $result,
        ]);
    }

    #[Route('/api/planets/{id}/stones', name: 'api_get_stones_planet_by_id', methods: ['GET', 'HEAD'])]
    public function getStonesPlanetById(PlanetRepository $planetRepository, int $id): JsonResponse
    {
        $result = [];
        /** @var Planet $planet */
        $planet = $planetRepository->findOneBy(['id' => $id]);
        $stones = $planet->getStones();

        /** @var StoneInterface $stone */
        foreach ($stones as $stone) {
            $itemResult = [
                'title' => $stone->getTitle(),
                'image' => ($stone->getImageName()) ? $this->getParameter('app.planets.images.uri').$stone->getImageName() : null,
                'slug' => $stone->getSlug(),
                'description' => $stone->getDescription(),
                'content' => $stone->getContent()
            ];
            if ($gallery = $stone->getGallery()) {
                /** @var GalleryEntityInterface $photo */
                foreach ($gallery as $photo) {
                    $itemResult['gallery'][] = [
                        'title' => $photo->getImageName(),
                        'image' => $this->getParameter('app.stones.images.uri').'/'.$photo->getImageName(),
                    ];
                }
            }
            $result[] = $itemResult;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'stones' => $result,
        ]);
    }

    #[Route('/api/planets/{id}/aromas', name: 'api_get_stones_planet_by_id', methods: ['GET', 'HEAD'])]
    public function getAromasPlanetById(PlanetRepository $planetRepository, int $id): JsonResponse
    {
        $result = [];
        /** @var Planet $planet */
        $planet = $planetRepository->findOneBy(['id' => $id]);
        $aromas = $planet->getAromas();

        /** @var StoneInterface $aroma */
        foreach ($aromas as $aroma) {
            $itemResult = [
                'title' => $aroma->getTitle(),
                'image' => ($aroma->getImageName()) ? $this->getParameter('app.aromas.images.uri').'/'.$aroma->getImageName() : null,
                'slug' => $aroma->getSlug(),
                'description' => $aroma->getDescription(),
                'content' => $aroma->getContent()
            ];
            if ($gallery = $aroma->getGallery()) {
                /** @var GalleryEntityInterface $photo */
                foreach ($gallery as $photo) {
                    $itemResult['gallery'][] = [
                        'title' => $photo->getImageName(),
                        'image' => $this->getParameter('app.aromas.images.uri').'/'.$photo->getImageName(),
                    ];
                }
            }
            $result[] = $itemResult;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'stones' => $result,
        ]);
    }
}
