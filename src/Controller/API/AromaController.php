<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Interfaces\AromaInterface;
use App\Interfaces\GalleryEntityInterface;
use App\Interfaces\PlanetInterface;
use App\Repository\AromaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AromaController extends AbstractController
{
    #[Route('/api/aromas/list', name: 'api_aromas_list', methods: ['GET', 'HEAD'])]
    public function stonesList(AromaRepository $aromaRepository): JsonResponse
    {
        $aromasResult = [];
        $aromas = $aromaRepository->findAll();

        foreach ($aromas as $aroma) {
            if (!$aroma->isPublished()) continue;
            $itemResult = [
                'id' => $aroma->getId(),
                'title' => $aroma->getTitle(),
                'image' => ($aroma->getImageName()) ? $this->getParameter('app.stones.images.uri') . $aroma->getImageName() : null,
                'slug' => $aroma->getSlug(),
                'description' => $aroma->getDescription(),
                'planet' => null,
                'api_link' => '/api/aromas/' . $aroma->getId()
            ];
            /** @var PlanetInterface $planet */
            $planet = $aroma->getPlanet();
            if ($planet instanceof PlanetInterface) {
                $itemResult['planet'] = [
                    'id' => $planet->getId(),
                    'title' => $planet->getTitle(),
                    'api_link' => '/api/planets/' . $planet->getId()
                ];
            }
            $aromasResult[] = $itemResult;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planets' => $aromasResult
        ]);
    }

    #[Route('/api/aromas/{id}', name: 'api_get_aroma_by_id', methods: ['GET', 'HEAD'])]
    public function getStoneById(AromaRepository $aromaRepository, int $id): JsonResponse
    {
        /** @var AromaInterface $aroma */
        $aroma = $aromaRepository->findOneBy(['id' => $id]);

        $result = [
            'id' => $aroma->getId(),
            'title' => $aroma->getTitle(),
            'image' => ($aroma->getImageName()) ? $this->getParameter('app.stones.images.uri') . $aroma->getImageName() : null,
            'slug' => $aroma->getSlug(),
            'description' => $aroma->getDescription(),
            "content" => $aroma->getContent()
        ];

        /** @var PlanetInterface $planet */
        $planet = $aroma->getPlanet();
        if ($planet instanceof PlanetInterface) {
            $result['planet'] = [
                'id' => $planet->getId(),
                'title' => $planet->getTitle(),
                'api_link' => '/api/planets/' . $planet->getId()
            ];
        }

        if ($gallery = $aroma->getGallery()) {
            /** @var GalleryEntityInterface $photo */
            foreach ($gallery as $photo) {
                $result['gallery'][] = [
                    'title' => $photo->getImageName(),
                    'image' => $this->getParameter('app.aromas.images.uri') . '/' . $photo->getImageName(),
                ];
            }
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'planet' => $result
        ]);
    }
}
