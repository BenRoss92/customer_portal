<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertContains(
          'Customer Portal', $crawler->filter('h1')->text()
        );
        $this->assertContains(
          'Basic Info:', $crawler->filter('h2')->text()
        );
        $this->assertContains(
          'Name: Ontro Ltd.', $crawler->filter('#name')->text()
        );
        $this->assertContains(
          'Address: 2 Chitty Street', $crawler->filter('#address')->text()
        );
        $this->assertContains(
          'City: London', $crawler->filter('#city')->text()
        );
        $this->assertContains(
          'Country: United Kingdom', $crawler->filter('#country')->text()
        );
    }
}
