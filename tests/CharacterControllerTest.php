<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Response;

class CharacterControllerTest extends WebTestCase
{
    private $client;
    
    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests redirect index
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/character');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $this->client->request('GET', '/character/index');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/character/display/49b7a65437aa9ba14a6ca5b10066b19d762cea47');

        $this->assertJsonReponse($this->client->getResponse());
    }

    /**
     * Asserts that a Reponse is in json
     */
    public function assertJsonReponse()
    {
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests bad identifier
     */
    public function testBadIdentifier()
    {
        $this->client->request('GET', '/character/display/badIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests that return 404
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Tests inexisting identifier
     */
    public function testInexistantIdentifier()
    {
        $this->client->request('GET', '/character/display/49b7a65437aa9ba14a6ca5b10066b19d762error');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }
}
