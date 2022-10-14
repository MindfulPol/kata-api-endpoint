<?php

namespace App\Domain\Entity;

class Price
{
    // TODO: Implement JsonSerialize and privatize attributes
    public int $original;
    public int $final;
    public ?string $discountPercentage;
    public string $currency;

    public function __construct(int $original, int $final, ?string $discountPercentage, string $currency)
    {
        $this->original = $original;
        $this->final = $final;
        $this->discountPercentage = $discountPercentage;
        $this->currency = $currency;
    }

    public function setFinal(int $final): void
    {
        $this->final = $final;
    }

    public function setDiscountPercentage(?string $discountPercentage): void
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function getFinal(): int
    {
        return $this->final;
    }
}
