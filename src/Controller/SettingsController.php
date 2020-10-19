<?php


namespace App\Controller;


use App\Entity\Screenshot;
use App\Form\UserSettingsType;
use App\ImageOptimizer;
use App\Repository\ScreenshotRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class SettingsController extends AbstractController
{

    private $entityManager;

    private $twig;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }


    /**
     * @param Request $request
     * @param UserRepository $repository
     * @param ScreenshotRepository $screenshotRepository
     * @param ImageOptimizer $imageOptimizer
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @IsGranted("ROLE_USER")
     * @Route("/settings", name="user_settings")
     */
    public function settings(Request $request, UserRepository $repository, ImageOptimizer $imageOptimizer): Response
    {


        $user = $repository->findOneBy(['username' => $this->getUser()->getUsername()]);
        $form = $this->createForm(UserSettingsType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getWebsite() !== 'https://') {

                $user->setWebsite($form->getData()->getWebsite());
            }

//            $avatar = $form->getData()->getAvatarFile();
            /*if ($avatar) {
                $destination = $this->getParameter('avatar_directory').'/'.$user->getId();
                $name = bin2hex(random_bytes(12));
                $avatarName = $name.'.'.$avatar->guessExtension();
                $avatarMiniName = $name.'-mini.'.$avatar->guessExtension();
                if ($user->getAvatar()) {
                    $this->entityManager->remove($user->getAvatar());
                }
                try {
                    unlink(
                        $destination.'/'.$user->getAvatar()
                    );
                    $extension = strstr($user->getAvatar(), '.');
                    $avatar_mini = str_replace($extension, '-mini'.$extension, $user->getAvatar());
                    unlink(
                        $destination.'/'.$avatar_mini
                    );
                } catch (\Exception $e) {
                }
                try {
                    $avatar->move($destination, $avatarName);
                    $imageOptimizer->resize(
                        $destination.'/'.$avatarName,
                        $destination.'/'.$avatarMiniName,
                        'cover'
                    );
                } catch (\Exception $e) {
                }
                $file = new Screenshot();
                $file->setUpdatedAt(new \DateTime());
                $file->setMini($avatarMiniName);
                $file->setFilename($avatarName);
                $user->setAvatar($file);
            }*/
            $this->entityManager->persist($user);
            $this->entityManager->flush();


        }


        return new Response(
            $this->twig->render(
                'security/settings.html.twig',
                [
                    'settings_form' => $form->createView(),
                ]
            )
        );

    }

    
}