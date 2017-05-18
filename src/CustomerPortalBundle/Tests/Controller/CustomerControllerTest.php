<?php

namespace CustomerPortalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
      $client = static::createClient();
      $crawler = $client->request('GET', '/');
      $crawler = $client->followRedirect();
      $new_sessions_url = $client->getRequest()->getUri();
      $this->assertContains('http://localhost/sessions/new', $new_sessions_url);
    }

    public function testNewSessions()
    {
      $client = static::createClient();
      $crawler = $client->request('GET', '/sessions/new');
      $this->assertContains(
        'Customer Portal', $crawler->filter('h1')->text()
      );
      $this->assertGreaterThan(0, $crawler->filter('#form_name')->count());
      $this->assertGreaterThan(0, $crawler->filter('#form_password')->count());

      $form = $crawler->selectButton('Login')->form(array(
        'form[name]' => 'Catalyst Climbing',
        'form[password]' => 'mypassword',
      ));
      $crawler = $client->submit($form);
      $crawler = $client->followRedirect();
      $this->assertContains('http://localhost/', $client->getRequest()->getUri());
    }
}
