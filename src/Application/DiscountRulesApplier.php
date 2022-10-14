<?php

namespace App\Application;

use App\Domain\Entity\Price;
use App\Domain\Entity\Product;

class DiscountRulesApplier
{
    private array $skuDiscount = [
                'readableDiscount' => '15%',
                'reduce' => 0.85,
                'trigger' => '0000003'
    ];
    private array $bootCategoryDiscount = [
                    'readableDiscount' => '30%',
                    'reduce' => 0.7,
                    'trigger' => 'boots'
    ];

    public function execute(array $products): array
    {
        foreach ($products as $key => $product) {
            if ($product->getCategory() === $this->bootCategoryDiscount['trigger']) {
                $price = $this->setNewPrice($product);
                $products[$key]->price = $price;
                continue; // avoid discounts collision
            }

            if ($product->getSku() === $this->skuDiscount['trigger']) {
                $price = $this->setNewPrice($product);
                $products[$key]->price = $price;
            }
        }

        return $products;
    }

    private function setNewPrice(Product $product): Price
    {
        $price = $product->getPrice();
        $newPrice = ceil($price->getFinal() * $this->bootCategoryDiscount['reduce']);
        $price->setFinal($newPrice);
        $price->setDiscountPercentage($this->bootCategoryDiscount['readableDiscount']);

        return $price;
    }
}
