<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Planet;
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
            ->disableUrlSignatures()
            ->generateRelativeUrls()
            ->setTranslationDomain('admin')
            ->disableDarkMode()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section(t('Content', [], 'menu'), '');
        yield MenuItem::linkToCrud(t('Planets', [], 'admin.menu'), 'fa fa-map', Planet::class)->setController(PlanetCrudController::class);
    }
}
