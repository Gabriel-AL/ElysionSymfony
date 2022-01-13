<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    /**
     * @Route("/validation", name="validation")
     */
    public function index(): Response
    {
        return $this->render('validation/index.html.twig', [
            'controller_name' => 'ValidationController',
        ]);
    }
}
