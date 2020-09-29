<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\User;
use App\Form\DeveloperRegistrationType;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

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
     */
    public function form(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $developer = new Developer();

        $form = $this->createForm(DeveloperRegistrationType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($developer, $developer->getPassword());
            $developer->setAvatar('-');
            $developer->setPassword($hash);


            $developer->setCreatedAt(new \DateTime());
            $this->entityManager->persist($developer);
            $this->entityManager->flush();

            $this->redirectToRoute('security_login',[
                'username'=>$developer->getUsername(),
            ]);
        }

        return $this->render(
            'security/signup.html.twig',
            [
                'sign_up_form' => $form->createView(),
                'is_classic_user'=>false,
            ]
        );

    }

    /**
     * @Route("/log-in", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/log-out", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/sign-up", name="security_user_sign_up")
     */
    public function signup(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setAvatar('-');
            $user->setCreatedAt(new \DateTime());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->redirectToRoute('security_login',[
                'username'=>$user->getUsername(),
            ]);
        }
        return $this->render(
            'security/signup.html.twig',
            [
                'sign_up_form' => $form->createView(),
                'is_classic_user'=>true,
            ]
        );
    }
}
