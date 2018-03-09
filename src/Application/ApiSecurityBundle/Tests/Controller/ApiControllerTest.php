<?php

namespace Application\ApiSecurityBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }


    // public function testCheckInAction() {
    //     $client  = static::createClient();
    //
    //     $data = array('AppUser' => 'admin', 'Password' => 'admin');
    //
    //     $crawler = $client->request( 'GET', '/api/checkin', $data, array( 'CONTENT_TYPE' => 'application/json' ) );
    //
    //     $response = $client->getResponse()->getContent();
    // }
}
