<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cost;

class Cost
{
    public function __construct(
        public readonly float $value,
        private readonly string $currency,
        private array $discounts = []
    ) {}

    public function addDiscount(Discount $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function getTotal(): float
    {
        return $this->value - array_sum(array_map(fn(Discount $discount) => $discount->value, $this->discounts));
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}