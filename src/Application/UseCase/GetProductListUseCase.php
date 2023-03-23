<?php

namespace App\Application\UseCase;

use App\Application\QueryStringParamDigestor;
use App\Domain\Repository\ProductRepositoryInterface;

class GetProductListUseCase
{
    
    public function __construct(
         private ProductRepositoryInterface $productRepository,
         private QueryStringParamDigestor $queryStringParamDigestor,
         private int $resultLimit = 5,
    ) {}

    public function execute(?string $queryStringParams = ''): array
    {
        $queryStringParams = $this->queryStringParamDigestor->execute($queryStringParams);
        return $this->productRepository->searchByCriteria($queryStringParams, $this->resultLimit);
    }
}
