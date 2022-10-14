<?php

namespace App\Infrastructure\Entrypoint\Api;

use App\Application\DiscountRulesApplier;
use App\Application\UseCase\GetProductListUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetProductListController
{
    private GetProductListUseCase $getProductListUseCase;
    private DiscountRulesApplier $discountRulesApplier;

    public function __construct(GetProductListUseCase $getProductListUseCase, DiscountRulesApplier $discountRulesApplier)
    {
        $this->getProductListUseCase = $getProductListUseCase;
        $this->discountRulesApplier = $discountRulesApplier;
    }

    public function __invoke(Request $request): Response
    {
        $products = $this->getProductListUseCase->execute($request->getQueryString());
        $products = $this->discountRulesApplier->execute($products);

        return new JsonResponse($products, Response::HTTP_OK);
    }
}
