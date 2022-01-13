<?php

namespace App\Controller\Front;

use App\Entity\Places;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="main_index")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $places = $doctrine->getRepository(Places::class)->findAllFromRoot();
        return $this->render('front/navigation/index.html.twig', [
            'places' => $places,
        ]);
    }
}
