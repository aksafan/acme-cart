<?php

declare(strict_types=1);

namespace App\Model\Cart\Application\UseCase\CalculateCartCost;

use App\Model\CalculatorInterface;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\DeliveryMethodFactory;

final readonly class Handler
{
    public function __construct(
        private CartRepositoryInterface $carts,
        private CalculatorInterface $calculator,
        private DeliveryMethodFactory $deliveryMethodFactory
    ) {
    }

    public function handle(Command $command): string
    {
        $cart = $this->carts->get($command->cartId);
        $cost = $this->calculator->getCost($cart->getItems());
        $costValue = $cost->getTotal();
        $deliveryMethod = $this->deliveryMethodFactory->getDeliveryMethod($costValue);
        $totalCartCost = round($costValue + $deliveryMethod->getCost(), 2, PHP_ROUND_HALF_DOWN);

        return sprintf('%s%s', $cost->getCurrency(), $totalCartCost);
    }
}
