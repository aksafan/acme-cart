<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\CalculateCartCost;

use App\Infrastructure\DataTypes\Id;

final readonly class Command
{
    public function __construct(
        public Id $cartId,
    ) {
    }
}
