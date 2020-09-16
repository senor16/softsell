<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Comment;
use App\Form\AppFormType;
use App\Form\CommentFormType;
use App\Repository\AppRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @Route("/app", name="app")
     */
    public function index(AppRepository $appRepository)
    {
        return new Response(
            $this->twig->render(
                'app/index.html.twig',
                ['apps' => $appRepository->findAll(),]
            )
        );
    }

    /**
     * @Route("/new", name="app_new")
     * @Route("/{slug}/edit" ,name="app_edit")
     */
    public function form(App $app = null, Request $request, string $photoDir)
    {
        if (!$app) {
            $app = new App();
        }
        $form = $this->createForm(AppFormType::class, $app);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$app->getId()) {
                $app->setCreatedAt(new \DateTime());
            }
            if($photo = $form['cover']->getData()){
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
            }
            $photoDir= $photoDir.'/'.$app->getDeveloper()->getId();
            try {
                mkdir($photoDir);
            }catch (\Exception $e){}
            try{
                $photo->move($photoDir, $filename);
            }catch (FileException $e){}
            $app->setCover($filename);
            $app->setPrice(0);
            $app->setViews(0);

            $this->entityManager->persist($app);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_show', ['slug' => $app->getSlug()]);
        }

        return new Response(
            $this->twig->render(
                'app/upload.html.twig',
                [
                    'app_form' => $form->createView(),
                    'edit_mode'=>$app->getId()!==null,
                ]
            )
        );
    }

    /**
     * @Route("/{slug}", name="app_show")
     */
    public function show(Request $request, App $app, CommentRepository $commentRepository)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setApp($app);
            $comment->setAuthor('Yaya Bar');
            $comment->setEmail('yaya@gmail.com');
            $comment->setCreatedAtValue();
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_show', ['slug' => $app->getSlug()]);
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPAginator($app, $offset);

        return new Response(
            $this->twig->render(
                'app/show.html.twig',
                [
                    'app' => $app,
                    'comments' => $paginator,
                    'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                    'comment_form' => $form->createView(),
                ]
            )
        );
    }

}
