<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class APINotificationController extends AbstractController
{
    /**
     * @Route("/get-notifications", name="get_notifications")
     */
    public function index(): Response
    {
        return $this->render('api_notification/index.html.twig', [
            'controller_name' => 'APINotificationController',
        ]);
    }
}
