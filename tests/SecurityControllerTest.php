<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginLogout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');

        //Login
        $form = $crawler->filter('button[type=submit]')->form();
        $form['email'] = 'admin@yopmail.com';
        $form['password'] = 'azertyuiop';
        $client->submit($form);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('title', 'Hello DefaultController!');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Logout');


        //Logout

        $crawler = $client->getCrawler();
        $link = $crawler->filter('a:contains("Logout")')->eq(0)->link();
        $crawler = $client->click($link);
        $client->followRedirect();

        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('title', 'Hello DefaultController!');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');

    }
}
