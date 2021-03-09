<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class PantherSecurityControllerTest extends PantherTestCase
{

    public function testLoginLogout(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');

        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testLoginLogout_0.png');
        $this->assertSelectorTextContains('h1', 'Please sign in');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');

        // Login
        $form = $crawler->filter('button[type=submit]')->form();
        $form['email'] = 'admin@yopmail.com';
        $form['password'] = 'azertyuiop';
        $client->submit($form);

        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testLoginLogout_1.png');
        $this->assertPageTitleContains('Hello DefaultController!');
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Logout');

        // Logout
        $crawler = $client->getCrawler();
        $link = $crawler->selectLink("Logout")->link();
        $crawler = $client->click($link);

        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testLoginLogout_2.png');
        $this->assertPageTitleContains('Hello DefaultController!');
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');
    }



    public function testLoginError()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/login');

        // Login
        $form = $crawler->filter('button[type=submit]')->form();
        $form['email'] = 'error@yopmail.com';
        $form['password'] = 'azertyuiop';
        $client->submit($form);

        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testLoginError_0.png');
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Email could not be found.');
    }




    public function login($login='admin@yopmail.com', $password='azertyuiop', $url='/login')
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', $url);

        // Login
        $form = $crawler->filter('button[type=submit]')->form();
        $form['email'] = $login;
        $form['password'] = $password;
        $client->submit($form);

        return $client;
    }

    public function testGetFormAddArticle()
    {

        $client = $this->login();
        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testGetFormAddArticle_0.png');

        $crawler = $client->getCrawler();
        $link = $crawler->selectLink("Administration")->link();
        $crawler = $client->click($link);
        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testGetFormAddArticle_1.png');

        $link = $crawler->selectLink("Article")->link();
        $crawler = $client->click($link);
        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testGetFormAddArticle_2.png');
        $this->assertSelectorTextContains('h1', 'Article index');

        $link = $crawler->selectLink("Create new")->link();
        $crawler = $client->click($link);
        $client->takeScreenshot('reportScreen/PantherSecurityControllerTest/testGetFormAddArticle_3.png');
        $this->assertSelectorTextContains('h1', 'Create new Article');
    }

}
