<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Interfaces\HTMLPageInterface;
use App\Interfaces\PageInterface;
use App\Repository\PageRepository;
use App\Repository\SectionRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    #[Route('/api/sections/list', name: 'app_api_routes', methods: ['GET', 'HEAD'])]
    public function index(SectionRepository $sectionRepository): JsonResponse
    {
        $result = [];
        $routes = $sectionRepository->findAll();

        foreach ($routes as $route) {
            if (!$route->isPublished()) {
                continue;
            }
            $section = [
                'id' => $route->getId(),
                'title' => $route->getTitle(),
                'link' => '/' . $route->getSlug(),
                'api_link' => '/api/sections/' . $route->getSlug() .'/content'
            ];

            if ($subPages = $route->getPages()) {
                /** @var PageInterface $page */
                foreach ($subPages as $page) {
                    $section['planets'][] = [
                        'id' => $page->getId(),
                        'planet_id' => $page->getPlanet()->getId(),
                        'title' => $page->getTitle(),
                        'link' => '/'.$route->getSlug() . '/' . $page->getPlanet()->getSlug(),
                        'api_link' => '/api/sections/' . $route->getSlug() . '/' . $page->getPlanet()->getSlug() . '/content'
                    ];
                }
            }
            $result[] = $section;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'routes' => $result,
        ]);
    }

    #[Route('/api/sections/{section}/content', name: 'api_get_content', methods: ['GET', 'HEAD'])]
    public function getContentSection(SectionRepository $sectionRepository, string $section): JsonResponse
    {
        $result = [];

        $sectionEntity = $sectionRepository->findOneBy(['slug' => $section]);
        if (!$sectionEntity) die('Not found');

        $result = [
            'id' => $sectionEntity->getId(),
            'title' => $sectionEntity->getTitle(),
            'description' => $sectionEntity->getDescription(),
            'content' => $sectionEntity->getContent()
        ];

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'routes' => $result,
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/api/sections/{section}/{planet}/content', name: 'api_get_content', methods: ['GET', 'HEAD'])]
    public function getPlanetContentSection(PageRepository $pageRepository, string $section, string $planet): JsonResponse
    {
        $result = [];

        /** @var HTMLPageInterface $pageEntity */
        $pageEntity = $pageRepository->getBySectionPlanet($section, $planet, AbstractQuery::HYDRATE_OBJECT);
        dump($pageEntity);

        if (!$pageEntity) die('Not found');

        $result = [
            'id' => $pageEntity->getId(),
            'title' => $pageEntity->getTitle(),
            'description' => $pageEntity->getDescription(),
            'content' => $pageEntity->getContent()
        ];

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'routes' => $result,
        ]);
    }
}
