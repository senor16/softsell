<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Comment;
use App\Entity\Developer;
use App\Entity\Executable;
use App\Entity\Screenshot;
use App\Form\AppFormType;
use App\Form\CommentFormType;
use App\Repository\AppRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function form(App $application = null, Request $request)
    {
        if (!$application) {
            $application = new App();
        }

        $form = $this->createForm(AppFormType::class, $application);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $screenshots = $form->get('screenshotsFile')->getData();
            dump($form->getData());

            if (!$application->getId()) {
                $application->setCreatedAt(new \DateTime());
            }
            $application->setPrice(0);
            $application->setViews(0);

            $this->entityManager->persist($application);
            $this->entityManager->flush();

            $destination = $this->getParameter('screenshots_directory').'/'.$form->get('developer')->getData()->getId().'/'.$application->getId();
            try {
                mkdir($destination);
             } catch (\Exception $e) {
            }

            foreach ($screenshots as $screenshot) {
                $screenshotname = bin2hex(random_bytes(12)).'.'.$screenshot->guessExtension();
//                $destination = $this->getParameter('screenshots_directory').'/'.$form->get('developer')->getData()->getId();

                try {
                    $screenshot->move($destination, $screenshotname);
                } catch (\Exception $e) {
                }

                $screen = new Screenshot();
                $screen->setFilename($screenshotname);
                $screen->setUpdatedAt(new \DateTime());

                $application->addScreenshot($screen);
            }

            $filedest = $this->getParameter('executables_directory').'/'.$form->get('developer')->getData()->getId(
                ).'/'.$application->getId();
            try {
                mkdir($filedest);
            } catch (\Exception $e) {dump($e);}

            if ($form->get('windows')->getData() and $form->getData()->getWindowsFile() !== null) {
                /* @var $windowsFile File*/
                $windowsFile = $form->getData()->getWindowsFile();
                $wexecutable = new Executable();
                $wexecutable->setSize($windowsFile->getSize());
                $wname = bin2hex(random_bytes(12)).'.'.$windowsFile->guessExtension();
                try {
                    $windowsFile->move($filedest, $wname);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                $wexecutable->setName($wname);
                $wexecutable->setPlatform('Windows');
                $wexecutable->setDownloads(0);
                $wexecutable->setUpdatedAt(new \DateTime());

                $application->addExecutable($wexecutable);
            }

            if ($form->get('linux')->getData() and $form->getData()->getLinuxFile() !== null) {
                /* @var $linuxFile File*/
                $linuxFile = $form->get('linuxFile')->getData();
                $lname = bin2hex(random_bytes(12)).'.'.$linuxFile->guessExtension();
                $lexecutable = new Executable();
                $lexecutable->setSize($linuxFile->getSize());
                try {
                    $linuxFile->move($filedest, $lname);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                $lexecutable->setName($lname);
                $lexecutable->setPlatform('Linux');
                $lexecutable->setDownloads(0);
                $lexecutable->setUpdatedAt(new \DateTime());

                $application->addExecutable($lexecutable);
            }

            if ($form->get('mac')->getData() and $form->getData()->getMacFile() !== null) {
                /* @var $macFile File*/
                $macFile = $form->get('macFile')->getData();
                $mname = bin2hex(random_bytes(12)).'.'.$macFile->guessExtension();
                $mexecutable = new Executable();
                $mexecutable->setSize($macFile->getSize());
                try {
                    $macFile->move($filedest, $mname);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                $mexecutable->setName($mname);
                $mexecutable->setPlatform('Mac');
                $mexecutable->setDownloads(0);
                $mexecutable->setUpdatedAt(new \DateTime());

                $application->addExecutable($mexecutable);
            }

            if ($form->get('android')->getData() and $form->getData()->getAndroidFile() !== null) {
                /* @var $androidFile File*/
                $androidFile = $form->get('androidFile')->getData();
                $aname = bin2hex(random_bytes(12)).'.'.$androidFile->guessExtension();
                $aexecutable = new Executable();
                $aexecutable->setSize($androidFile->getSize());
                try {
                    $androidFile->move($filedest, $aname);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                $aexecutable->setName($aname);
                $aexecutable->setPlatform('Android');
                $aexecutable->setDownloads(0);
                $aexecutable->setUpdatedAt(new \DateTime());

                $application->addExecutable($aexecutable);
            }


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
                    'application'=>$application,

                ]
            )
        );


    }

    /**
     * @Route("/{slug}", name="application_show", priority="-10")
     * @Route("/{slug}" , name="comment_show" ,defaults={"_fragment": "comments"},priority="-10")
     */
    public function show(Request $request, App $application, CommentRepository $commentRepository)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setApp($application);
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

    /**
     * @Route("/delete/screenshots/{id}", name="application_delete_screenshot", methods={"DELETE"})
     */
    public function deleteScreenshot(Screenshot $screenshot, Request $request){
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('screenshot'.$screenshot->getId(), $data['_token'])) {
            unlink(
                $this->getParameter('screenshots_directory').'/'.$screenshot->getApp()->getDeveloper()->getId(
                ).'/'.$screenshot->getApp()->getId().'/'.$screenshot->getFilename()
            );

            $this->entityManager->remove($screenshot);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error'=>'Token invalide'],400);
        }
    }

    /**
     * @Route("/delete/executable/{id}", name="application_delete_executable", methods={"DELETE"})
     */
    public function deleteExecutable(Executable $executable, Request $request){
        $data = json_decode($request->getContent(),true);
        if($this->isCsrfTokenValid('executable'.$executable->getId(), $data['_token'])){
            unlink(
                $this->getParameter('executables_directory').'/'.$executable->getApp()->getDeveloper()->getId(
                ).'/'.$executable->getApp()->getId().'/'.$executable->getName()
            );

            $this->entityManager->remove($executable);
            $this->entityManager->flush();

            return new JsonResponse(['success'=>1]);
        }else{
            return new JsonResponse(['error'=>'Token invalide'], 400);
        }
    }
}

