<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class PantherDefaultControllerTest extends PantherTestCase
{
    public function testIndex(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

       // $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');
        $this->assertPageTitleContains('Hello DefaultController!');
        //$this->assertSelectorTextContains('title', 'Hello DefaultController!');
    }

}
