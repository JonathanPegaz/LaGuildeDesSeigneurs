<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\CharacterServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class CharacterController extends AbstractController
{
    private $characterService;

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }

    /**
     * @Route("/character", name="character_redirect_index", methods={"GET","HEAD"})
     * Redirects to index Route
     *  @OA\Response(response=302,description="Redirect")
     *  @OA\Tag(name="Character")
     */
    public function redirectIndex(): Response
    {
        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/character/index", name="character_index", methods={"GET","HEAD"})
    *  Displays available Characters
    *  @OA\Response(response=200,description="Success",
    *      @OA\Schema(type="array",
    *          @OA\Items(ref=@Model(type=Character::class))
    *      )
    *  )
    *  @OA\Response(response=403,description="Access denied")
    *  @OA\Tag(name="Character")
    */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAll();
        return new JsonResponse($characters);
    }

    //DISPLAY
    /**
     * @Route("/character/display/{identifier}", name="character_display", requirements={"identifier": "^([a-z0-9]{40})$"}, methods={"GET","HEAD"})
     * 
     * @OA\Parameter(
     *      name="identifier",
     *      in="path",
     *      description="identifier for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name= "Character")
     */
    public function display(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return new JsonResponse($character->toArray());
    }

    /**
     * @Route("/character/create", name="character_create", methods={"POST","HEAD"})
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\RequestBody(
     *      request="Character",
     *      description="Data for the Character",
     *      required= true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref="#/components/schemas/Character")
     *      )
     * )
     * @OA\Tag(name= "Character")
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('characterCreate', null);
        $character = $this->characterService->create($request->getContent());
        return new JsonResponse($character->toArray());
    }
    /**
     * Route('/character/life/{life}', name: 'character_index_life', requirements: ["life" => "^([0-9]{1,3})$"], methods: ["GET", "HEAD"])
     * Display the character by life contained in the url
     * 
     * @OA\Parameter(
     *      name="life",
     *      in="path",
     *      description="life for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexLife(int $life)
    {
        $this->denyAccessUnlessGranted('characterLife', null);
        $characters = $this->characterService->getByLife($life);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    /**
     * Route('/character/caste/{caste}', name: 'character_index_caste', requirements: ["caste" => "[^/]+"], methods: ["GET", "HEAD"])
     * Display the character by caste contained in the url
     * 
     * @OA\Parameter(
     *      name="caste",
     *      in="path",
     *      description="caste for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexCaste(string $caste)
    {
        $this->denyAccessUnlessGranted('characterCaste', null);
        $characters = $this->characterService->getByCaste($caste);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }

    /**
     * Route('/character/knowledge/{knowledge}', name: 'character_index_knowledge', requirements: ["knowledge" => "[^/]+"], methods: ["GET", "HEAD"])
     * Display the character by knowledge contained in the url
     * 
     * @OA\Parameter(
     *      name="knowledge",
     *      in="path",
     *      description="knowledge for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name="Character")
     */
    public function indexKnowledge(string $knowledge)
    {
        $this->denyAccessUnlessGranted('characterKnowledge', null);
        $characters = $this->characterService->getByKnowledge($knowledge);
        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }
    //MODIFY
    /**
    * @Route("/character/modify/{identifier}",
    * name="character_modify",
    * requirements={"identifier": "^([a-z0-9]{40})$"},
    * methods={"PUT", "HEAD"}
    * )
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @Model(type=Character::class),
    * )
    * @OA\Response(
    *      response=403,
    *      description="Access denied",
    * )
    * @OA\Parameter(
     *      name="identifier",
     *      in="path",
     *      description="identifier for the Character",
     *      required=true,
     * )
    * @OA\RequestBody(
    *      request="Character",
    *      description="Data for the Character",
    *      required= true,
    *      @OA\MediaType(
    *          mediaType="application/json",
    *          @OA\Schema(ref="#/components/schemas/Character")
    *      )
    * )
    * @OA\Tag(name= "Character")
    */
    public function modify(Request $request, Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character, $request->getContent());
        return new JsonResponse($character->toArray());
    }
    //DELETE
    /**
    * @Route("/character/delete/{identifier}",
    * name="character_delete",
    * requirements={"identifier": "^([a-z0-9]{40})$"},
    * methods={"DELETE", "HEAD"}
    * )
    * @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\Schema(
    *       @OA\Property(property="delete", type="boolean"),
    *      ),
    * )
    * @OA\Response(
    *      response=403,
    *      description="Access denied",
    * )
    * @OA\Parameter(
    *      name="identifier",
    *      in="path",
    *      description="identifier for the Character",
    *      required=true,
    * )
    * @OA\Tag(name="Character")
    */
    public function delete(Character $character): Response
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }

    //IMAGES
    /**
    * Returns images randomly using kind
    * @Route("/character/images/{kind}/{number}",
    *     name="character_images_kind",
    *     requirements={"number": "^([0-9]{1,2})$"},
    *     methods={"GET", "HEAD"}
    * )
    */
    public function imagesKind(string $kind, int $number)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        return new JsonResponse($this->characterService->getImagesKind($kind, $number));
    }

    /**
     * @Route("/character/intelligence/{intelligence}", name="character_intelligence", requirements={"intelligence": "^([0-9]{0,3})$"}, methods={"GET","HEAD"})
     * 
     * @OA\Parameter(
     *      name="intelligence",
     *      in="path",
     *      description="intelligence for the Character",
     *      required=true,
     * )
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @Model(type=Character::class),
     * )
     * @OA\Response(
     *      response=403,
     *      description="Access denied",
     * )
     * @OA\Response(
     *      response=404,
     *      description="Not Found",
     * )
     * @OA\Tag(name= "Character")
     */
    public function getAboveIntelligence(int $intelligence)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $characters = $this->characterService->getAboveIntelligence($intelligence);

        return JsonResponse::fromJsonString($this->characterService->serializeJson($characters));
    }
}
