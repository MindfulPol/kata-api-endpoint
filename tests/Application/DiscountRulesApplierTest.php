<?php

namespace App\Tests\Application;

use App\Application\DiscountRulesApplier;
use App\Tests\Domain\ProductMother;
use PHPUnit\Framework\TestCase;

class DiscountRulesApplierTest extends TestCase
{

    public function testShouldApplyThirtyPercentDiscountToProductsInBootCategory()
    {
        $originalProductMotherPrice = 500;
        $priceWithThirtyPercentApplied = 350;
        $discountRulesApplier = new DiscountRulesApplier();
        $products = ProductMother::createMultipleProductsPricedAsFiveHundred();
        $products = $discountRulesApplier->execute($products);
        foreach ($products as $product) {
            if ($product->category !== 'boots') {
                $this->assertEquals($originalProductMotherPrice, $product->getPrice()->getFinal());
            } else {
                $this->assertEquals($priceWithThirtyPercentApplied, $product->getPrice()->getFinal());
            }
        }
    }
}
