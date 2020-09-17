<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{
    /**
     * @Route("/developer", name="developer")
     */
    public function index()
    {
        return $this->render('developer/index.html.twig', [
            'controller_name' => 'DeveloperController',
        ]);
    }
}
