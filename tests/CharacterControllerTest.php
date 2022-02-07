<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Response;

class CharacterControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $client = static::createClient();
        $client->request('GET', '/character/display');

        $this->assertJsonReponse($client->getResponse());
    }

    /**
     * Asserts that a Reponse is in json
     */
    public function assertJsonReponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
