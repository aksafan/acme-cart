<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\AddCartItem;

use App\Infrastructure\DataTypes\Id;
use App\Infrastructure\DataTypes\Price;

final readonly class Command
{
    public function __construct(
        public Id $cartId,
        public string $productCode,
        public int $quantity,
        public Price $price
    ) {
    }
}
