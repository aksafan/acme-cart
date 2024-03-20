<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cart;

use App\Infrastructure\DataTypes\Price;

final readonly class CartItem
{
    public function __construct(
        public string $productCode,
        public int $quantity,
        public Price $price
    ) {
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getCost(): float
    {
        return $this->price->amount * $this->quantity;
    }

    public function getPriceAmount(): float
    {
        return $this->price->amount;
    }

    public function getCurrency(): string
    {
        return $this->price->currency;
    }

    public function addQuantity(int $quantity): CartItem
    {
        return new self(
            productCode: $this->productCode,
            quantity: $this->quantity + $quantity,
            price: $this->price
        );
    }

    public function changeQuantity(int $quantity): CartItem
    {
        return new self(
            productCode: $this->productCode,
            quantity: $quantity,
            price: $this->price
        );
    }
}
