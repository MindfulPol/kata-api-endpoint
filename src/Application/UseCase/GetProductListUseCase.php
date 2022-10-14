<?php

namespace App\Application\UseCase;

use App\Application\QueryStringParamDigestor;
use App\Domain\Repository\ProductRepositoryInterface;

class GetProductListUseCase
{
    private ProductRepositoryInterface $productRepository;
    private QueryStringParamDigestor $queryStringParamDigestor;
    private int $resultLimit = 5;

    public function __construct(ProductRepositoryInterface $productRepository, QueryStringParamDigestor $queryStringParamDigestor)
    {
        $this->productRepository = $productRepository;
        $this->queryStringParamDigestor = $queryStringParamDigestor;
    }

    public function execute(?string $queryStringParams = ''): array
    {
        $queryStringParams = $this->queryStringParamDigestor->execute($queryStringParams);
        return $this->productRepository->searchByCriteria($queryStringParams, $this->resultLimit);
    }
}
