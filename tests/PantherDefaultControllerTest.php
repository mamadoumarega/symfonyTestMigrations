<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class PantherDefaultControllerTest extends PantherTestCase
{
    public function testIndex(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $client->takeScreenshot('reportScreen/PantherDefaultControllerTest/testIndex_0.png');
        $this->assertPageTitleContains('Hello DefaultController!');
        $this->assertSelectorTextContains('.navbar-brand', 'CW24 Symfony');
        $this->assertSelectorTextContains('.navbar-nav li:last-child', 'Login');
    }


    public function testGotoSignin(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');
        $link    = $crawler->selectLink('Login')->link();
        $crawler = $client->click($link);

        $client->takeScreenshot('reportScreen/PantherDefaultControllerTest/testGotoSignin_0.png');
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }


    public function testSlider(): void {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');


        // test btn next
        for($i=1; $i<=count($crawler->filter(".slides li")); $i++){

            // eq attend un index donc $i - 1
            // l'assertVisibleSlide attend le numero d'element pour du xpath donc $i
            $client->takeScreenshot("reportScreen/PantherDefaultControllerTest/testSlider_{$i}_next.png");
            $this->assertEquals('active', $crawler->filter(".slides li")->eq($i - 1)->attr('class'));
            $this->assertVisibleSlide($crawler, $i);
            $client->executeScript("document.querySelector('#btn-next').click()");
        }


        // test btn prev
        for($i=count($crawler->filter(".slides li")); $i>=1; $i--){

            if($i==count($crawler->filter(".slides li"))){

                // lors du dernier tour de la boucle de la premiere boucle,
                // derniere operation click next donc retour a la premiere slide
                $client->takeScreenshot('reportScreen/PantherDefaultControllerTest/testSlider_1_next_b.png');
                $this->assertEquals('active', $crawler->filter(".slides li")->eq(0)->attr('class'));
                $this->assertVisibleSlide($crawler, 1);
                $client->executeScript("document.querySelector('#btn-prev').click()");
            }

            // eq attend un index donc $i - 1
            // l'assertVisibleSlide attend le numero d'element pour du xpath donc $i
            $client->takeScreenshot("reportScreen/PantherDefaultControllerTest/testSlider_{$i}_prev.png");
            $this->assertEquals('active', $crawler->filter(".slides li")->eq($i - 1)->attr('class'));
            $this->assertVisibleSlide($crawler, $i);
            $client->executeScript("document.querySelector('#btn-prev').click()");
        }

        // lors du dernier tour de la boucle de la premiere boucle,
        // derniere operation click prev donc retour a la derniere slide
        $lastSlide = count($crawler->filter(".slides li"));
        $client->takeScreenshot("reportScreen/PantherDefaultControllerTest/testSlider_{$lastSlide}_prev_b.png");
        $this->assertEquals('active', $crawler->filter(".slides li")->eq($lastSlide - 1)->attr('class'));
        $this->assertVisibleSlide($crawler, $lastSlide);

    }



    public function assertVisibleSlide($crawler, $index) {
        for($i=1; $i<=count($crawler->filter(".slides li")); $i++){
            if ($i == $index) {
                $this->assertSelectorIsVisible("//div[contains(@class, 'slider')]/ul/li[$i]");
            } else {
                $this->assertSelectorIsNotVisible("//div[contains(@class, 'slider')]/ul/li[$i]");
            }
        }
    }
}