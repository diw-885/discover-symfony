<?php

namespace App\Model;

class Product
{
    private $name;
    public $slug;
    public $description;
    public $price;

    public function __construct($n, $d, $p)
    {
        $this->name = $n;
        // Génération du slug "dynamique"
        $this->slug = strtolower(str_replace(' ', '-', $n));
        $this->description = $d;
        $this->price = $p;
    }

    public function getName()
    {
        return $this->name;
    }
}
