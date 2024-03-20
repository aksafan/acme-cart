<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\AddProduct;

use App\Model\Cart\Domain\Entity\Cart\Id;

final readonly class Command
{
    public function __construct(
        public Id $cartId,
        public string $productCode,
        public int $quantity
    ) {
    }
}
