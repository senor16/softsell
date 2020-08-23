<?php

namespace App\Controller\Admin;

use App\Entity\App;
use App\Entity\Comment;
use App\Entity\Genre;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
//        return parent::index();
        //Redirect to some crud controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(CommentCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Softsell');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
//        yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
        return [
          MenuItem::linktoDashboard('Dashboard','fa fa-home'),
          MenuItem::linkToCrud('User','fa fa-user',User::class),
          MenuItem::linkToCrud('Comments','fa fa-comments',Comment::class),
          MenuItem::linkToCrud('Genre','fa fa-tag',Genre::class),
          MenuItem::linkToCrud('App','fa fa-cloud',App::class)
        ];
    }
}
