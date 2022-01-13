<?php

namespace App\Controller\Front;

use App\Form\Front\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, ManagerRegistry $doctrine): Response
    {
        $registrationForm = $this->createForm(RegistrationType::class);
        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $em = $doctrine->getManager();
            $account = $registrationForm->getData();
            $em->persist($account);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('front/security/register.html.twig', [
            'form' => $registrationForm->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logOut(): void
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
