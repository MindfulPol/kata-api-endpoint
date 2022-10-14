<?php

namespace App\Domain\Entity;

class Product
{
    // TODO: Implement JsonSerialize and privatize attributes
    public string $sku;
    public string $name;
    public string $category;
    public Price $price;

    public function __construct(string $sku, string $name, string $category, Price $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }
}
