<?php

declare(strict_types=1);

namespace App\Model;

interface DeliveryMethodInterface
{
    public const ORDER_COST_50 = 50.00;
    public const ORDER_COST_90 = 90.00;

    public function getCost(): float;
}
