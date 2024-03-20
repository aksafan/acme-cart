<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\ClearCart;

use App\Infrastructure\DataTypes\Id;

final readonly class Command
{
    public function __construct(
        public Id $cartId
    ) {
    }
}
