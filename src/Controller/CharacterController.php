<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends AbstractController
{
    /**
     * @Route("/character/display", name="character_display")
     */
    public function display() 
    {
        $character = new Character();

        return new JsonResponse($character->toArray());
    }
}
