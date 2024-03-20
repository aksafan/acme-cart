<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\RemoveProduct;

use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\Flusher;

final readonly class Handler
{
    public function __construct(
        private CartRepositoryInterface $carts,
        private Flusher $flusher
    ) {
    }

    public function handle(Command $command): void
    {
        $cart = $this->carts->get($command->cartId);
        $cart->remove($command->productCode);

        $this->flusher->flush();
    }
}
