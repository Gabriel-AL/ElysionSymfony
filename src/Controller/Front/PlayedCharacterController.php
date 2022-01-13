<?php

namespace App\Controller\Front;

use App\Entity\PlayedCharacter;
use App\Form\Front\PlayedCharacterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/characters", name="characters_")
 */
class PlayedCharacterController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;    
    }

    /**
     * @Route("/", name="list")
     */
    public function characterList(): Response
    {
        $characters = $this->doctrine->getRepository(PlayedCharacter::class)->findAll();
        return $this->render('front/playedcharacter/list_all.html.twig', [
            'characters' => $characters,
        ]);
    }

    /**
     * @Route("/mine", name="mine")
     */
    public function characterListMine(): Response
    {
        $characters = $this->doctrine->getRepository(PlayedCharacter::class)->findBy(['account'=>$this->getUser()]);
        return $this->render('front/playedcharacter/list_mine.html.twig', [
            'characters' => $characters,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newCharacter(Request $request): Response
    {
        $character = new PlayedCharacter();
        $character->setAccount($this->getUser());

        $form = $this->createForm(PlayedCharacterType::class, $character);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->persist($character);
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute("characters_mine");
        }

        return $this->render('front/playedcharacter/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
