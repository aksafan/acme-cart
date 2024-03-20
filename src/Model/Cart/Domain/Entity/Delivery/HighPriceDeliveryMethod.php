<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Delivery;

use App\Model\DeliveryMethodInterface;

final class HighPriceDeliveryMethod implements DeliveryMethodInterface
{
    protected const COST = 0.00;

    public function getCost(): float
    {
        return self::COST;
    }
}