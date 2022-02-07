<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\CharacterServiceInterface;

class CharacterController extends AbstractController
{

    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    /**
     * @Route("/character", name="character", methods={"GET","HEAD"})
     */
    public function index():Response
    {
        return $this->json([
            'message'=>'Welcome to controller',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }
    /**
     * @Route("/character/display", name="character_display", methods={"GET","HEAD"})
     */
    public function display() 
    {
        $character = new Character();

        return new JsonResponse($character->toArray());
    }
    /**
     * @Route("/character/create", name="character_create", methods={"POST","HEAD"})
     */
    public function create() 
    {
        $character = $this->characterService->create();
        return new JsonResponse($character->toArray());
    }
}
