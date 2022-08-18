<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Aroma;
use App\Entity\Planet;
use App\Entity\Section;
use App\Entity\Stone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Makeeva site')
            ->renderContentMaximized()
//            ->disableUrlSignatures()
//            ->generateRelativeUrls()
            ->setTranslationDomain('admin')
            ->disableDarkMode()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud(t('Sections', [], 'admin.menu'), 'fa fa-map', Section::class)
            ->setController(SectionCrudController::class)
        ;
        yield MenuItem::section(t('Content', [], 'admin.menu'), '');
        yield MenuItem::linkToCrud(t('Planets', [], 'admin.menu'), 'fa fa-map', Planet::class)
            ->setController(PlanetCrudController::class)
        ;
        yield MenuItem::linkToCrud(t('Stones', [], 'admin.menu'), 'fa fa-map', Stone::class)
            ->setController(StoneCrudController::class)
        ;
        yield MenuItem::linkToCrud(t('Aromas', [], 'admin.menu'), 'fa fa-map', Aroma::class)
            ->setController(AromaCrudController::class)
        ;
    }
}
