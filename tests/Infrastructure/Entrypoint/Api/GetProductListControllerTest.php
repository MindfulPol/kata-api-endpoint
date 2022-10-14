<?php

namespace App\Tests\Infrastructure\Entrypoint\Api;


use App\Application\DiscountRulesApplier;
use App\Application\UseCase\GetProductListUseCase;
use App\Infrastructure\Entrypoint\Api\GetProductListController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class GetProductListControllerTest extends TestCase
{
    private GetProductListUseCase $getProductListUseCase;
    private DiscountRulesApplier $discountRulesApplier;

    public function setUp(): void
    {
        $this->getProductListUseCase = $this->createMock(GetProductListUseCase::class);
        $this->discountRulesApplier = $this->createMock(DiscountRulesApplier::class);
    }

    public function testShouldTriggerGetProductListUseCase() : void
    {
        $this->getProductListUseCase
            ->expects($useCaseSpy = self::any())
            ->method('execute')
        ;

        $getProductListController = new GetProductListController($this->getProductListUseCase, $this->discountRulesApplier);
        $request = new Request();
        ($getProductListController)($request);

        $this->assertTrue($useCaseSpy->hasBeenInvoked());
    }

    public function testShouldTriggerDiscountRulesService() : void
    {
        $this->discountRulesApplier
            ->expects($useCaseSpy = self::any())
            ->method('execute')
        ;

        $getProductListController = new GetProductListController($this->getProductListUseCase, $this->discountRulesApplier);
        $request = new Request();
        ($getProductListController)($request);

        $this->assertTrue($useCaseSpy->hasBeenInvoked());
    }
}
