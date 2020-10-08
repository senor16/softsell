<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\AppDownload;
use App\Entity\Comment;
use App\Entity\Executable;
use App\Entity\Screenshot;
use App\Entity\User;
use App\Form\AppFormType;
use App\Form\CommentFormType;
use App\Repository\AppDownloadRepository;
use App\Repository\AppRepository;
use App\Repository\CommentRepository;
use App\Repository\ExecutableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @IsGranted("ROLE_DEVELOPER")
     * @Route("/dashboard", name="dashboard")
     */
    public function index(AppRepository $appRepository)
    {
        return new Response(
            $this->twig->render(
                'app/index.html.twig',
                ['applications' => $appRepository->findBy(['developer' => $this->getUser(),]),]
            )
        );
    }

    /**
     * @IsGranted("ROLE_DEVELOPER")
     * @Route("/new", name="application_new")
     * @Route("/{slug}/edit" ,name="application_edit" ,priority=-10)
     * @param App|null $application
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function form(App $application = null, Request $request, ExecutableRepository $executableRepository)
    {
        if (!$application) {
            $application = new App();
        } else {
            if ($this->getUser() !== $application->getDeveloper()) {
                return $this->redirectToRoute('application_show', ['slug' => $application->getSlug()]);
            }
        }

        $form = $this->createForm(AppFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $screenshots = $form->get('screenshotsFile')->getData();


            if (!$application->getId()) {
                $application->setCreatedAt(new \DateTime());

                $application->setPrice(0);
                $application->setViews(0);
                $application->setDeveloper($this->getUser());
            }
            $this->entityManager->persist($application);
            $this->entityManager->flush();

            $destination = $this->getParameter('screenshots_directory').'/'.$this->getUser()->getId(
                ).'/'.$application->getId();
            try {
                mkdir($destination);
            } catch (\Exception $e) {
            }

            foreach ($screenshots as $screenshot) {
                $screenshotname = bin2hex(random_bytes(12)).'.'.$screenshot->guessExtension();

                try {
                    $screenshot->move($destination, $screenshotname);
                } catch (\Exception $e) {
                }

                $screen = new Screenshot();
                $screen->setFilename($screenshotname);
                $screen->setUpdatedAt(new \DateTime());

                $application->addScreenshot($screen);
            }

            $filedest = $this->getParameter('executables_directory').'/'.$this->getUser()->getId(
                ).'/'.$application->getId();
            try {
                mkdir($filedest);
            } catch (\Exception $e) {

            }

            if ($form->get('windows')->getData() and $form->getData()->getWindowsFile() !== null) {

                foreach ($application->getExecutables() as $executable) {
                    if ($executable->getPlatform() === "Windows") {
                        unlink($filedest.'/'.$executable->getName());
                        $this->entityManager->remove($executable);
                        $this->entityManager->flush();
                    }
                }


                /* @var $windowsFile File */
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
                foreach ($application->getExecutables() as $executable) {
                    if ($executable->getPlatform() === "Linux") {
                        unlink($filedest.'/'.$executable->getName());
                        $this->entityManager->remove($executable);
                        $this->entityManager->flush();
                    }
                }
                /* @var $linuxFile File */
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
                foreach ($application->getExecutables() as $executable) {
                    if ($executable->getPlatform() === "Mac") {
                        unlink($filedest.'/'.$executable->getName());
                        $this->entityManager->remove($executable);
                        $this->entityManager->flush();
                    }
                }
                /* @var $macFile File */
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
                foreach ($application->getExecutables() as $executable) {
                    if ($executable->getPlatform() === "Android") {
                        unlink($filedest.'/'.$executable->getName());
                        $this->entityManager->remove($executable);
                        $this->entityManager->flush();
                    }
                }
                /* @var $androidFile File */
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
                    'application' => $application,
                ]
            )
        );
    }

    /**
     * @Route("/{slug}", name="application_show", priority="-10")
     * @Route("/{slug}" , name="comment_show" ,defaults={"_fragment": "comments"},priority="-10")
     * @param Request $request
     * @param App $application
     * @param CommentRepository $commentRepository
     * @return RedirectResponse|Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(Request $request, App $application, CommentRepository $commentRepository)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setApp($application);
            $comment->setCreatedAtValue();
            $comment->setAuthor($this->getUser()->getFirstName().' '.$this->getUser()->getLastName());
            $comment->setEmail($this->getUser()->getEmail());
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
     * @IsGranted("ROLE_DEVELOPER")
     * @Route("/delete/screenshots/{id}", name="application_delete_screenshot", methods={"DELETE"})
     * @param Screenshot $screenshot
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteScreenshot(Screenshot $screenshot, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('screenshot'.$screenshot->getId(), $data['_token'])) {
            unlink(
                $this->getParameter('screenshots_directory').'/'.$screenshot->getApp()->getDeveloper()->getId(
                ).'/'.$screenshot->getApp()->getId().'/'.$screenshot->getFilename()
            );

            $this->entityManager->remove($screenshot);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }

    /**
     * @IsGranted("ROLE_DEVELOPER")
     * @Route("/delete/executable/{id}", name="application_delete_executable", methods={"DELETE"})
     * @param Executable $executable
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteExecutable(Executable $executable, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('executable'.$executable->getId(), $data['_token'])) {
            unlink(
                $this->getParameter('executables_directory').'/'.$executable->getApp()->getDeveloper()->getId(
                ).'/'.$executable->getApp()->getId().'/'.$executable->getName()
            );

            $this->entityManager->remove($executable);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }

    /**
     * @param App $app
     * @param AppDownloadRepository $appDownloadRepository
     * @param ExecutableRepository $executableRepository
     * @param $platform
     * @return Response
     * @Route(" /{slug}/download/{platform}", name="application_download")
     * @throws \Exception
     */
    public function download(
        App $app,
        AppDownloadRepository $appDownloadRepository,
        ExecutableRepository $executableRepository,
        $platform
    ): Response {
        $user = $this->getUser();
        if ($user) {


            if (!$app->isDownloadedBy($user)) {
                $download = new AppDownload();
                $download->setCreatedAt(new \DateTime())
                    ->setPlatform($platform)
                    ->setApp($app);
                $download->setUser($user);


                $this->entityManager->persist($download);
                $this->entityManager->flush();
            }

        }
        $allowed_platform = [
            'Windows',
            'Linux',
            'Mac',
            'Android',
        ];
        $platform = ucwords($platform);
        if (in_array($platform, $allowed_platform)) {
            $executable = $executableRepository->findOneBy(['app' => $app, 'platform' => $platform]);
            if ($executable) {
                $executable->setDownloads($executable->getDownloads() + 1);
                $this->entityManager->flush();

                $filedest = $this->getParameter('executables_download').'/'.$app->getDeveloper()->getId(
                    ).'/'.$app->getId().'/'.$executable->getName();

                return $this->redirect($filedest);


            } else {
                return $this->json(['code' => 404, 'message' => 'Fichié non trouvé.'], 404);
            }

        } else {
            return $this->json(['code' => 404, 'message' => 'Plateforme incorrecte'], 404);
        }
    }

    /**
     * @param App $app
     * @param Request $request
     * @IsGranted("ROLE_DEVELOPER")
     * @Route("{slug}/delete", name="application_delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteApp(App $app, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('application'.$app->getId(), $data['_token'])) {
            foreach ($app->getExecutables() as $executable) {
                try {
                    unlink(
                        $this->getParameter('executables_directory').'/'.$this->getUser()->getId().'/'.$app->getId(
                        ).'/'.$executable->getName()
                    );
                }catch (\Exception $e){}
                $this->entityManager->remove($executable);
            }
            rmdir($this->getParameter('executables_directory').'/'.$this->getUser()->getId().'/'.$app->getId());

            foreach ($app->getScreenshots() as $screenshot) {
                try {
                    unlink(
                        $this->getParameter('screenshots_directory').'/'.$this->getUser()->getId().'/'.$app->getId(
                        ).'/'.$screenshot->getFilename()
                    );
                }catch (\Exception $e){}
                $this->entityManager->remove($screenshot);
            }
            rmdir($this->getParameter('screenshots_directory').'/'.$this->getUser()->getId().'/'.$app->getId());

            unlink($this->getParameter('cover_directory').'/'.$this->getUser()->getId().'/'.$app->getCover());

            $this->entityManager->remove($app);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        }else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }

    /**
     * @IsGranted("ROLE_USER")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @Route("/library", name="application_library")
     */
    public function library():Response{

        return new Response($this->twig->render('app/library.html.twig'));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @Route("/recommendations", name="application_recommendations")
     */
    public function recommendations():Response{

        return new Response($this->twig->render('app/recommendations.html.twig'));
    }

    /**
     * @return Response
     * @Route("/search/{search}", name="apllication_search")
     */
    public function search($search, AppRepository $appRepository):Response{
        return new Response($this->twig->render('app/search.html.twig'));
    }
}

