<?php

namespace App\Tests\Application\UseCase;

use App\Application\QueryStringParamDigestor;
use App\Application\UseCase\GetProductListUseCase;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetProductListUseCaseTest extends TestCase
{

    public function testShouldReturnAtMostFiveProducts()
    {
        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->once())
            ->method('searchByCriteria')
            ->with([], 5);

        $getProductListUseCase = new GetProductListUseCase($productRepository, new QueryStringParamDigestor());
        $getProductListUseCase->execute();
    }

    public function testShouldHandleQueryParamString()
    {
        $queryStringParamDigestor = $this->createMock(QueryStringParamDigestor::class);
        $queryStringParamDigestor
            ->expects($useCaseSpy = self::any())
            ->method('execute')
        ;
        $productRepository = $this->createMock(ProductRepositoryInterface::class);

        $getProductListUseCase = new GetProductListUseCase($productRepository, $queryStringParamDigestor);
        $getProductListUseCase->execute();

        $this->assertTrue($useCaseSpy->hasBeenInvoked());
    }
}
