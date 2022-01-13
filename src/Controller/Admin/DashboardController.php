<?php

namespace App\Controller\Admin;

use App\Entity\Places;
use App\Entity\Category;
use App\Entity\CharacterSheetCategory;
use App\Entity\CharacterSheetProperty;
use App\Entity\Item;
use App\Entity\Shops;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ElysionSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-sign-out-alt', 'main_index');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Actions');
        yield MenuItem::section('Configuration - Boutiques');
        yield MenuItem::linkToCrud('Boutiques', 'fas fa-shopping-basket', Shops::class);
        yield MenuItem::linkToCrud('Objets', 'fas fa-gift', Item::class);
        yield MenuItem::section('Configuration - Lieux');
        yield MenuItem::linkToCrud('Lieux', 'fas fa-globe-americas', Places::class);

    }
}
