<?php

namespace App\Models;

class Product
{
    public string $name;
    public string $description;
    public string $price;

    /**
     * Product constructor.
     * @param string $name
     * @param string $description
     * @param string $price
     */
    public function __construct(string $name, string $description, string $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
