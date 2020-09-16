<?php

namespace App\Controller\Admin;

use App\Entity\App;
use App\Entity\Comment;
use App\Entity\Developer;
use App\Entity\Executable;
use App\Entity\Genre;
use App\Entity\Language;
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
     * @Route("/easyadmin", name="admin")
     */
    public function index(): Response
    {
//        return parent::index();
        //Redirect to some crud controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(AppCrudController::class)->generateUrl());
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
          MenuItem::linkToCrud('Developer','fa fa-user-circle',Developer::class),
          MenuItem::linkToCrud('User','fa fa-user',User::class),
          MenuItem::linkToCrud('App','fa fa-file-code',App::class),
          MenuItem::linkToCrud('Executable','fa fa-file',Executable::class),
          MenuItem::linkToCrud('Comments','fa fa-comments',Comment::class),
          MenuItem::linkToCrud('Genre','fa fa-tags',Genre::class),
          MenuItem::linkToCrud('Language','fa fa-american-sign-language-interpreting',Language::class),
        ];
    }
}
