<?php

namespace App\Controller\Front;

use App\Entity\Places;
use App\Entity\RP;
use App\Form\Front\RPType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rp/", name="rp_")
 */
class RPController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("new/{place}", name="new")
     */
    public function newRP(Request $request, Places $place) {
        $rp = new RP();
        $rp->setPlace($place);
        
        $form = $this->createForm(RPType::class, $rp);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $firstPost = $form->get('rpposts')->getData()->first();
            $firstPost->setRpIn($rp);
            $this->doctrine->getManager()->persist($rp);
            $this->doctrine->getManager()->flush();
        }

        return $this->render('front/rp/newrp.html.twig', [
            'form' => $form->createView(),
            'place' => $place
        ]);
    }

    public function answer() {

    }

    public function edit() {

    }
}
