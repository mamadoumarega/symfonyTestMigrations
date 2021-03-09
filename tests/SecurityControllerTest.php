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

    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        //Login
        $form = $crawler->filter('button[type=submit]')->form();
        $form['email'] = 'error@yopmail.com';
        $form['password'] = 'azertyuiop';
        $client->submit($form);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Email could not be found.');

    }

    public function getFormArticle(): void
    {
        $client = $this->testLogin();
        $crawler = $client->getCrawler();
        $link = $crawler->filter('a:contains("Article")')->eq(0)->link();
        $crawler = $client->click($link);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Article index');


        $link = $crawler->filter('a:contains("Create new")')->eq(0)->link();
        $crawler = $client->click($link);
        $this->assertSelectorTextContains('h1', 'Create new Article');

    }

    /*
     * public function testGetFormField(): void
    {
        $client = $this->testLogin();
        $crawler = $client->request('GET', '/article/new');


        $form = $crawler->filter('button.btn.btn-primary')->form();
        $client->submit($form);
        $client->followRedirect();

        $form['article[name]'] != ' ';
        $form['article[description]'] != ' ';
        $form['article[price]'] != ' ';
        $form['article[category]'] != ' ';

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Article');
        $this->assertSelectorTextContains('label[for=article_name]', 'Name');
        $this->assertSelectorTextContains('label[for=article_description]', 'Description');
        $this->assertSelectorTextContains('label[for=article_price]', 'Price');
        $this->assertSelectorTextContains('label[for=article_category]', 'Category');
    }
     */

}
