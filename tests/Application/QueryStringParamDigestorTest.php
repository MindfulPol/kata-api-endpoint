<?php

namespace App\Tests\Application;

use App\Application\QueryStringParamDigestor;
use PHPUnit\Framework\TestCase;

class QueryStringParamDigestorTest extends TestCase
{

    public function testTransformsQueryParamStringIntoArray()
    {
        $queryStringDigestor = new QueryStringParamDigestor();
        $queryStringToArray = $queryStringDigestor->execute('category=boots&priceLessThan=50');
        $expected = [
          'category' => 'boots',
          'priceLessThan' => 50
        ];
        $this->assertEquals($expected, $queryStringToArray);
    }
}
