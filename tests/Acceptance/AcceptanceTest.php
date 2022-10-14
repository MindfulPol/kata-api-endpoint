<?php

namespace App\Tests\Acceptance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class AcceptanceTest extends ApiTestCase
{
    public function test_get_products_must_return_at_most_5_elements()
    {
        $client = self::createClient();
        $response = $client->request('GET', '/products', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $products = json_decode($response->getContent(), true);

        $this->assertTrue(count($products) <= 5 && count($products) >= 1);
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    public function test_get_products_can_filter_by_category_as_query_string()
    {
        $client = self::createClient();
        $response = $client->request('GET', '/products?category=boots', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $products = json_decode($response->getContent(), true);

        foreach ($products as $product) {
            $this->assertEquals('boots', $product['category']);
        }
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    public function test_products_in_boots_category_have_thirty_percent_discount()
    {
        $client = self::createClient();
        $response = $client->request('GET', '/products?category=boots', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $products = json_decode($response->getContent(), true);

        foreach ($products as $product) {
            $this->assertEquals('30%', $product['price']['discountPercentage']);
        }
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    public function test_products_applies_biggest_discount_if_more_than_one_collides()
    {
        $client = self::createClient();
        $response = $client->request('GET', '/products?sku=000003', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $products = json_decode($response->getContent(), true);

        foreach ($products as $product) {
            $this->assertEquals('30%', $product['price']['discountPercentage']);
        }
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }
}
