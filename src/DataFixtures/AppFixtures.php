<?php

namespace App\DataFixtures;

use App\Domain\Entity\Price;
use App\Domain\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $productFixturesFilePath = "'/productFixtures.json'";

    public function load(ObjectManager $manager): void
    {
        $productFixtures = json_decode(file_get_contents(__DIR__ . "/productFixtures.json"), true);
        foreach ($productFixtures['products'] as $productFixture) {
            $price = new Price($productFixture['price'], $productFixture['price'], null, '€');
            $product = new Product(
                $productFixture['sku'],
                $productFixture['name'],
                $productFixture['category'],
                $price
            );
            $manager->persist($product);
        }

        $manager->flush();
    }
}
