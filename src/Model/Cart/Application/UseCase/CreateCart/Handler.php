<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\CreateCart;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\Id;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\Flusher;
use DateTimeImmutable;

final readonly class Handler
{
    public function __construct(
        private CartRepositoryInterface $carts,
        private Flusher $flusher
    ) {
    }

    public function handle(Command $command): void
    {
        $cart = new Cart(
            id: Id::generate(),
            date: new DateTimeImmutable(),
            items: $command->items
        );

        $this->carts->add($cart);

        $this->flusher->flush();
    }
}