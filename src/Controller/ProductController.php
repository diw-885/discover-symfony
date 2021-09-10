<?php

namespace App\Controller;

use App\Model\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $products;

    public function __construct()
    {
        // J'initialise mon tableau produit ("Fausse" base de données)
        $this->products = [
            //'iphone-x' => ['name' => 'iPhone X', 'slug' => 'iphone-x', 'description' => 'Un iPhone de 2017', 'price' => 999],
            //'iphone-xr' => ['name' => 'iPhone XR', 'slug' => 'iphone-xr', 'description' => 'Un iPhone de 2018', 'price' => 1099],
            //'iphone-xs' => ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2019', 'price' => 1199],
            'iphone-x' => new Product('iPhone X', 'Un iPhone de 2017', 999),
            'iphone-xr' => new Product('iPhone XR', 'Un iPhone de 2018', 1099),
            'iphone-xs' => new Product('iPhone XS', 'Un iPhone de 2019', 1199),
            'iphone-11' => new Product('iPhone 11', 'Un iPhone de 2020', 1199),
            'iphone-12' => new Product('iPhone 12', 'Un iPhone de 2021', 1199),
        ];
    }

    /**
     * Cette page affiche la liste des produits.
     *
     * @Route("/product/{page}", name="product", requirements={"page": "\d+"})
     */
    public function index($page = 1): Response
    {
        // array_values transforme le tableau associatif en numérique
        $products = array_values($this->products);

        // On doit récupérer 2 produits
        // Si on est sur la page 1, on récupère l'index 0 et 1
        // Si on est sur la page 2, on récupère l'index 2 et 3
        // Si on est sur la page 3, on récupère l'index 4 et 5
        $products = array_chunk($products, 2);
        /* Le chunk fait la transformation suivante :
            [
              0 => ['iphone x', 'iphone xs'],
              1 => ['iphone xr', 'iphone 11'],
              2 => ['iphone 12']
            ]
        */
        if (! isset($products[$page - 1])) {
            throw $this->createNotFoundException("La page $page n'existe pas.");
        }

        return $this->render('product/index.html.twig', [
            'products' => $products[$page - 1],
            'page' => $page,
        ]);
    }

    /**
     * @Route("/product/random", name="product_random")
     */
    public function random()
    {
        return $this->render('product/show.html.twig', [
            // array_rand renvoie une clé aléatoirement du tableau
            'product' => $this->products[array_rand($this->products)]
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        return $this->render('product/create.html.twig');
    }

    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        // Je vérifie si le produit existe dans le tableau
        if (! isset($this->products[$slug])) {
            // throw signifie qu'on lève une exception
            throw $this->createNotFoundException("Le produit $slug n'existe pas.");
        }

        return $this->render('product/show.html.twig', [
            'product' => $this->products[$slug],
        ]);
    }

    /**
     * @Route("/product.json", name="product_json")
     */
    public function api()
    {
        return $this->json($this->products);
    }
}
