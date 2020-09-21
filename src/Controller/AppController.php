<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Comment;
use App\Entity\Screenshot;
use App\Form\AppFormType;
use App\Form\CommentFormType;
use App\Form\ScreenshotFormType;
use App\Repository\AppRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AppController extends AbstractController
{
    private $twig;
    private $entityManager;


    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/app", name="application")
     */
    public function index(AppRepository $appRepository)
    {
        return new Response(
            $this->twig->render(
                'app/index.html.twig',
                ['applications' => $appRepository->findAll(),]
            )
        );
    }

    /**
     * @Route("/new", name="application_new")
     * @Route("/{slug}/edit" ,name="application_edit" ,priority=-10)
     */
    public function form(App $application = null,  Request $request, string $imageDir)
    {
        if (!$application) {
            $application = new App();
        }

        $form = $this->createForm(AppFormType::class, $application);
            $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            if (!$application->getId()) {
                $application->setCreatedAt(new \DateTime());
            }
            $application->setPrice(0);
            $application->setViews(0);

            $this->entityManager->persist($application);
            $this->entityManager->flush();


            return $this->redirectToRoute('application_show', ['slug' => $application->getSlug()]);
        }


        return new Response(
            $this->twig->render(
                'app/upload.html.twig',
                [
                    'application_form' => $form->createView(),
                    'edit_mode' => $application->getId() !== null,
                ]
            )
        );
    }

    /**
     * @Route("/{slug}", name="application_show")
     * @Route("/{slug}", name="comment_show")
     */
    public function show(Request $request, App $application, CommentRepository $commentRepository)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setApp($application);
            $comment->setAuthor('Capi ar');
            $comment->setEmail('capili@gmail.com');
            $comment->setCreatedAtValue();
            $this->entityManager->persist($comment);
            $this->entityManager->flush();


            return $this->redirectToRoute('comment_show', ['slug' => $application->getSlug()]);
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPAginator($application, $offset);

        return new Response(
            $this->twig->render(
                'app/show.html.twig',
                [
                    'application' => $application,
                    'comments' => $paginator,
                    'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                    'comment_form' => $form->createView(),
                ]
            )
        );
    }

}
