<?php

namespace App\Controller\Admin;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\CategorieCrudController;
use App\Controller\Admin\ReponseCrudController;


use App\Entity\Categorie;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    
            
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MVC My Quiz');
    }

    public function configureMenuItems(): iterable
    {
        
        yield MenuItem::linkToCrud('Users', 'fa fa-home', User::class);
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Questions', 'fa fa-list', Question::class);
        yield MenuItem::linkToCrud('Reponses', 'fa fa-list', Reponse::class);
    }
}
