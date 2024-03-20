<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\ChangeQuantity;

use App\Model\Cart\Domain\Entity\Cart\Id;
use App\Model\Cart\Domain\Entity\Product\Id as ProductId;

final readonly class Command
{
    public function __construct(
        public Id $cartId,
        public ProductId $productId,
        public int $quantity,
    ) {
    }
}
