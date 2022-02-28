<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Response;

class PlayerControllerTest extends WebTestCase
{
    private $client;
    private $content;
    private static $identifier;

    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);
        //...
    }
    /**
     * Asserts that 'identifier' is present in the Response
    */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }
    /**
    * Defines identifier
    */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }
    
    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function testCreate()
    {
        $this->client->request(
            'POST',
            '/player/create',
            array(),//parameters
            array(),//files
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"firstname":"Jo", "lastname":"peg", "email":"pegazjonathan@gmail.com", "mirian":"20"}'
        );
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests redirect index
     */
    public function testRedirectIndex()
    {
        $this->client->request('GET', '/player');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $this->client->request('GET', '/player/index');

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/player/display/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests modify
     */
    public function testModify()
    {
        //Tests with partial data array
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(),//parameters
            array(),//files
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"firstname":"test", "lastname":"ueueue"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();
        //Tests with whole content
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(),//parameters
            array(),//files
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"firstname":"nico", "lastname":"elden", "email":"elden@gmail.com", "mirian":"200"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();
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
        $this->client->request('GET', '/player/display/badIdentifier');
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
        $this->client->request('GET', '/player/display/49b7a65437aa9ba14a6ca5b10066b19d762error');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
    * Tests delete
    */
    public function testDelete()
    {
        $this->client->request('DELETE', '/player/delete/' . self::$identifier);
        $this->assertJsonResponse();
    }

}
