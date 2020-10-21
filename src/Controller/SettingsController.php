<?php


namespace App\Controller;


use App\Form\EmailFormType;
use App\Form\PasswordFormType;
use App\Form\UserSettingsType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @IsGranted("ROLE_USER")
     * @Route("/settings", name="user_settings")
     */
    public function settings(Request $request, UserRepository $repository): Response
    {


        $user = $repository->findOneBy(['username' => $this->getUser()->getUsername()]);
        $form = $this->createForm(UserSettingsType::class, $user);
        $form->handleRequest($request);
        $success = false;

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
            $success = true;


        }


        return new Response(
            $this->twig->render(
                'security/settings.html.twig',
                [
                    'settings_form' => $form->createView(),
                    'success' => $success,
                ]
            )
        );

    }

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @IsGranted("ROLE_USER")
     * @Route("/settings/change-password", name="user_change_password")
     */
    public function password(
        Request $request,
        UserRepository $repository,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $user = $repository->findOneBy(['username' => $this->getUser()->getUsername()]);
        $form = $this->createForm(PasswordFormType::class, $user);
        $form->handleRequest($request);
        $success = false;
        if ($form->isSubmitted() && $form->isValid()) {


            $old_password = $encoder->encodePassword($user, $form->getData()->getOldPassword());
            if ($old_password === $user->getPassword()) {

                $new_password = $encoder->encodePassword($user, $form->getData()->getNewPassword());
                $user
                    ->setPassword($new_password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $success = true;
            } else {
                $form->get('oldPassword')->addError(new FormError('Mot de passe incorrect'));
            }
        }


        return new Response(
            $this->twig->render(
                'security/password.html.twig',
                [
                    'password_form' => $form->createView(),
                    'success' => $success,
                ]
            )
        );
    }

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @IsGranted("ROLE_USER")
     * @Route("/settings/change-email", name="user_change_email")
     */
    public function Email(Request $request, UserRepository $repository, UserPasswordEncoderInterface $encoder): Response
    {

        $success = false;
        $show = false;
        $user = $repository->findOneBy(['username' => $this->getUser()->getUsername()]);
        $form = $this->createForm(EmailFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $encoder->encodePassword($user, $form->getData()->getOldPassword());
            if ($password === $user->getPassword()) {
                $email = $form->getData()->getNewEmail();
                $user->setEmail($email);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $this->redirectToRoute('user_change_email', ['success' => true, 'show' => false]);

            } else {
                return $this->redirectToRoute('user_change_email', ['success' => false, 'show' => true]);
            }
        }

        if ($request->get('success')) {
            $success = $request->get('success');
            $show = $request->get('show');
        }

        return new Response(
            $this->twig->render(
                'security/email.html.twig',
                [
                    'email_form' => $form->createView(),
                    'success' => $success,
                    'show' => $show,
                ]
            )
        );
    }

}