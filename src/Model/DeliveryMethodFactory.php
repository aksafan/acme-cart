<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Cart\Domain\Entity\Delivery\HighPriceDeliveryMethod;
use App\Model\Cart\Domain\Entity\Delivery\LowPriceDeliveryMethod;
use App\Model\Cart\Domain\Entity\Delivery\MediumPriceDeliveryMethod;

class DeliveryMethodFactory
{
    public function getDeliveryMethod(float $totalPrice): DeliveryMethodInterface
    {
        if ($totalPrice < DeliveryMethodInterface::ORDER_COST_50) {
            return new LowPriceDeliveryMethod();
        }
        if ($totalPrice < DeliveryMethodInterface::ORDER_COST_90) {
            return new MediumPriceDeliveryMethod();
        }

        return new HighPriceDeliveryMethod();
    }
}
