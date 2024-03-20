<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cart;

use App\Model\Cart\Domain\Entity\Product\Id as ProductId;
use App\Model\Cart\Domain\Entity\Product\Product;
use DomainException;

final readonly class CartItem
{
    public function __construct(
        public Product $product,
        public int $quantity
    ) {
        if (!$product->canBeCheckout($quantity)) {
            throw new DomainException('Quantity is too big.');
        }
    }

    public function getProductId(): ProductId
    {
        return $this->product->id;
    }

    public function getProductCode(): string
    {
        return $this->product->code;
    }

    public function getCost(): float
    {
        return $this->getPriceAmount() * $this->quantity;
    }

    public function getCurrency(): string
    {
        return $this->product->getCurrency();
    }

    public function addQuantity(int $quantity): CartItem
    {
        return new self(
            product: $this->product,
            quantity: $this->quantity + $quantity
        );
    }

    public function changeQuantity(int $quantity): CartItem
    {
        return new self(
            product: $this->product,
            quantity: $quantity
        );
    }

    private function getPriceAmount(): float
    {
        return $this->product->getPriceAmount();
    }
}
