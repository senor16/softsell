<?php

namespace App\Controller;

use App\Entity\App;
use App\Repository\AppRepository;
use App\Repository\CommentRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AppController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/app", name="app")
     */
    public function index(AppRepository $appRepository)
    {
        return new Response($this->twig->render('app/index.html.twig',
            ['apps' => $appRepository->findAll(),]
        ));
    }

    /**
     * @Route("/app/{id}", name="app-details")
     */
    public function show(Request $request, App $app, CommentRepository $commentRepository){
        $offset = max(0, $request->query->getInt('offset',0));
        $paginator=$commentRepository->getCommentPAginator($app, $offset);

        return new Response($this->twig->render('app/show.html.twig', [
            'app' => $app,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' =>min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]));
    }
}
