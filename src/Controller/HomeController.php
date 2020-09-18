<?php

namespace App\Controller;

use App\Repository\AppRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AppRepository $appRepository)
    {
        return $this->render('home/index.html.twig', [
            'applications' => $appRepository->findAll(),
            'controller_name' => 'HomeController'
        ]);

    }
}
