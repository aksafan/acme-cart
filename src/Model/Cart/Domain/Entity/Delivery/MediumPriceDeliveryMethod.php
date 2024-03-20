<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Delivery;

use App\Model\DeliveryMethodInterface;

final class MediumPriceDeliveryMethod implements DeliveryMethodInterface
{
    protected const COST = 2.95;

    public function getCost(): float
    {
        return self::COST;
    }
}