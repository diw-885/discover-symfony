<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index(): Response
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }

    /**
     * @Route("/discover/{page}", name="demo_list", requirements={"page": "\d+"})
     */
    public function list($page = 1)
    {
        return $this->render('demo/list.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * On peut passer des paramètres dans les URLs.
     *
     * @Route("/discover/{title}", name="demo_show", requirements={"title": "[a-f]{1,6}"})
     */
    public function show($title)
    {
        return $this->render('demo/show.html.twig', [
            'title' => $title,
        ]);
    }
}
