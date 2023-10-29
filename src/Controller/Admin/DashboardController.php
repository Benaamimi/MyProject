<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Peinture;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            ->setTitle('TarikBen.');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Accueil du site', 'fa fa-igloo', 'home');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Actualités', 'fas fa-newspaper', Blogpost::class);
        yield MenuItem::linkToCrud('Peintures', 'fas fa-palette', Peinture::class);
        yield MenuItem::linkToCrud('commentaires', 'fas fa-comment', Commentaire::class);
        yield MenuItem::linkToCrud('Paramètres', 'fa fa-cog', User::class);
    }


}
