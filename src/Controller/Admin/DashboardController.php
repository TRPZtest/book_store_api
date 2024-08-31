<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
  
        $url = $routeBuilder->setController(BookCrudController::class)->generateUrl();

        return $this->redirect($url);        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Book Store Api');
    }

    public function configureMenuItems(): iterable
    {   
      /*   yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'index'); */
        yield MenuItem::linkToCrud('Books', 'fa-solid fa-book', Book::class);
        yield MenuItem::linkToCrud('Categories', 'fa-solid fa-layer-group', Category::class);
        yield MenuItem::linkToCrud('Tags','fas fa-tag', Tag::class);
    }
}
