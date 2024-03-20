<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\CreateCart;

use App\Model\Cart\Domain\Entity\Cart\CartItem;

final readonly class Command
{
    public function __construct(
        /** @var CartItem[] $items */
        public array $items
    ) {
    }
}