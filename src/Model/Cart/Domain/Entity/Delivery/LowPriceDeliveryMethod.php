<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Delivery;

use App\Model\DeliveryMethodInterface;

final class LowPriceDeliveryMethod implements DeliveryMethodInterface
{
    protected const COST = 4.95;

    public function getCost(): float
    {
        return self::COST;
    }
}