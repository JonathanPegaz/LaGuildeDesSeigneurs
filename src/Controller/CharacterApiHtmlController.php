<?php

namespace App\Controller;

use App\Form\CharacterApiHtmlType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/character/api-html")
 */
class CharacterApiHtmlController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/", name="character_api_html_index", methods={"GET"})
     */
    public function index(): Response
    {
        $response = $this->client->request('GET','http://api.la-guilde-des-seigneurs.com/character/index');
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/life/{life}", name="character_api_html_life",requirements={"life" = "^([0-9]{1,3})$"}, methods={"GET"})
     */
    public function indexLife(int $life)
    {
        $response = $this->client->request(
            'GET',
            'http://localhost:80/character/life/' . $life
        );
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/caste/{caste}", name="character_api_html_caste",requirements={"caste" = "[^/]+"}, methods={"GET"})
     */
    public function indexCaste(string $caste)
    {
        $response = $this->client->request(
            'GET',
            'http://localhost:80/character/caste/' . $caste
        );
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/knowledge/{knowledge}", name="character_api_html_knowledge",requirements={"knowledge" = "[^/]+"}, methods={"GET"})
     */
    public function indexKnowledge(string $knowledge)
    {
        $response = $this->client->request(
            'GET',
            'http://localhost:80/character/knowledge/' . $knowledge
        );
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/new", name="character_api_html_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $character = array();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $this->client->request('POST','http://api.la-guilde-des-seigneurs.com/character/create',
            ['json' => $request->request->all()['character_api_html'],]);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $response->toArray()['identifier'],
            ));
        }

        return $this->renderForm('character_api_html/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{identifier}", name="character_api_html_show", methods={"GET"})
     */
    public function show(string $identifier): Response
    {
        $response = $this->client->request('GET','http://api.la-guilde-des-seigneurs.com/character/display/' . $identifier);
        return $this->render('character_api_html/show.html.twig', [
            'character' => $response->toArray(),
        ]);
    }

    /**
     * @Route("/{identifier}/edit", name="character_api_html_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, string $identifier): Response
    {
        $response = $this->client->request('GET','http://api.la-guilde-des-seigneurs.com/character/display/' . $identifier);
        $character = $response->toArray();
        $form = $this->createForm(CharacterApiHtmlType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->client->request('PUT','http://api.la-guilde-des-seigneurs.com/character/modify/' . $identifier,
            [
                'json' => $request->request->all()['character_api_html'],
                'body' => json_encode($request->request->all()['character_api_html']),
            ]);

            return $this->redirectToRoute('character_api_html_show', array(
                'identifier' => $identifier,
            ));
        }

        return $this->renderForm('character_api_html/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{identifier}", name="character_api_html_delete", methods={"POST"})
     */
    public function delete(Request $request, string $identifier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getIdentifier(), $request->request->get('_token'))) {
            $this->client->request('DELETE','http://api.la-guilde-des-seigneurs.com/character/delete/' . $identifier,);
        }

        return $this->redirectToRoute('character_api_html_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/intelligence/{intelligence}", name="character_api_html_intelligence", methods={"GET"})
     */
    public function intelligenceIndex(int $intelligence)
    {
        $response = $this->client->request('GET','http://api.la-guilde-des-seigneurs.com/character/intelligence/' . $intelligence);
        return $this->render('character_api_html/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }
}
