<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Interfaces\PageInterface;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    #[Route('/api/sections/list', name: 'app_api_routes')]
    public function index(SectionRepository $sectionRepository): JsonResponse
    {
        $result = [];
        $routes = $sectionRepository->findAll();

        foreach ($routes as $route) {
            if (!$route->isPublished()) continue;
            $section = [
                'id' => $route->getId(),
                'title' => $route->getTitle(),
                'link' => '/' . $route->getSlug(),
            ];

            if ($subPages = $route->getPages()) {
                /** @var PageInterface $page */
                foreach ($subPages as $page) {
                    $section['planets'][] = [
                        'id' => $page->getId(),
                        'planet_id' => $page->getPlanet()->getId(),
                        'title' => $page->getTitle(),
                        'link' => '/' . $route->getSlug() . '/' . $page->getPlanet()->getSlug(),
                    ];
                }
            }
            $result[] = $section;
        }

        return new JsonResponse([
            'status' => Response::HTTP_OK,
            'routes' => $result
        ]);
    }
}
