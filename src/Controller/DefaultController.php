<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'articles' => $articleRepository->findBy(["state"=>"published"]),
        ]);
    }
}
