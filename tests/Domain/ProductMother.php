<?php

namespace App\Tests\Domain;

use App\Domain\Entity\Price;
use App\Domain\Entity\Product;

class ProductMother
{
    public static function createMultipleProductsPricedAsFiveHundred(): array
    {
        $fakeProducts = [];
        for ($i = 1; $i <= 5; $i++) {
            $price = new Price(500, 500, null, '€');
            $product = new Product('00000' . $i, 'test', 'boots', $price);
            if ($i % 2 !== 0) {
                $product->category = 'hats';
            }
            $fakeProducts[] = $product;
        }

        return $fakeProducts;
    }
}