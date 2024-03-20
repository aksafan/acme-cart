<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\AddProduct;

use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\Cart\Domain\Repository\ProductRepositoryInterface;
use App\Model\Flusher;

final readonly class Handler
{
    public function __construct(
        private CartRepositoryInterface $carts,
        private ProductRepositoryInterface $products,
        private Flusher $flusher
    ) {}

    public function handle(Command $command): void
    {
        $product = $this->products->getByCode($command->productCode);
        $cart = $this->carts->get($command->cartId);
        $cart->add(
            new CartItem(
                product: $product,
                quantity: $command->quantity
            )
        );

        $this->flusher->flush();
    }
}