<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');
        $this->assertSelectorTextContains('title', 'Hello DefaultController!');
    }

    public function testGotoSignin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->filter('a:contains("Login")')->eq(0)->link();
        $crawler = $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

}
