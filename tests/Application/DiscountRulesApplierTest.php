<?php

namespace App\Tests\Application;

use App\Application\DiscountRulesApplier;
use App\Tests\Domain\ProductMother;
use PHPUnit\Framework\TestCase;

class DiscountRulesApplierTest extends TestCase
{

    public function testShouldApplyThirtyPercentDiscountToProductsInBootCategory()
    {
        $discountRulesApplier = new DiscountRulesApplier();
        $products = ProductMother::createMultipleProductsPricedAsFiveHundred();
        $products = $discountRulesApplier->execute($products);
        foreach ($products as $product) {
            if ($product->category !== 'boots') {
                $this->assertEquals(500, $product->price->final);
            } else {
                $this->assertEquals(350, $product->price->final);
            }
        }
    }
}
