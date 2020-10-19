<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SecurityController extends AbstractController
{


    private $entityManager;

    private $twig;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/developer/sign-up", name="security_developer_sign_up")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function form(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setAvatar('-')
                ->setPassword($hash)
                ->setRole('ROLE_DEVELOPER')
                ->setCreatedAt(new \DateTime());

            $this->entityManager->persist($user);
            $this->entityManager->flush();



            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'security/signup.html.twig',
            [
                'sign_up_form' => $form->createView(),
                'is_classic_user' => false,
            ]
        );

    }


    /**
     * @Route("/sign-up", name="security_user_sign_up")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash)
                ->setAvatar('-')
                ->setRole('ROLE_USER')
                ->setCreatedAt(new \DateTime());


            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'security/signup.html.twig',
            [
                'sign_up_form' => $form->createView(),
                'is_classic_user' => true,
            ]
        );
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @IsGranted("ROLE_USER")
     * @Route("/profile", name="user_profile")
     */
    public function profile(): Response
    {

        return new Response($this->twig->render('security/profile.html.twig'));
    }





}
