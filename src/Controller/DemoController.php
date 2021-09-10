<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'cars' => [
                ['brand' => '<h1>Renault</h1>'],
                ['brand' => 'Peugeot'],
                ['brand' => 'Citroen'],
            ],
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

    /**
     * Un exemple de formulaire sans le composant Form.
     *
     * @Route("/discover/create", name="demo_create")
     */
    public function create(Request $request)
    {
        // Avec Symfony, on n'utilise plus $_GET ou $_POST
        // On va utiliser un objet Request
        dump($request);
        // Equivalent de $_GET['page'] ?? null
        dump($request->query->get('page'));
        dump($request->get('page')); // Raccourci

        // Equivalent de $_POST['message'] ?? null
        dump($request->request->get('message'));
        dump($request->get('message'));

        // On peut faire des redirections et/ou créer des messages flashs
        if ($request->get('message') === 'secret') {
            $this->addFlash('success', 'Le message a été envoyé');
            // return $this->redirect('https://google.fr');
            return $this->redirectToRoute('demo_list');
        }

        return $this->render('demo/create.html.twig', [
            'message' => $request->get('message'),
        ]);
    }
}
