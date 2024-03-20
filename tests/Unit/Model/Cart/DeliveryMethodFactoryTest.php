<?php

declare(strict_types=1);

namespace Unit\Model\Cart;

use App\Model\Cart\Domain\Entity\Delivery\HighPriceDeliveryMethod;
use App\Model\Cart\Domain\Entity\Delivery\LowPriceDeliveryMethod;
use App\Model\Cart\Domain\Entity\Delivery\MediumPriceDeliveryMethod;
use App\Model\DeliveryMethodFactory;
use PHPUnit\Framework\TestCase;

class DeliveryMethodFactoryTest extends TestCase
{
    public function testGetLowPriceDeliveryMethod(): void
    {
        $factory = new DeliveryMethodFactory();
        $totalPrice = 40.00;

        $deliveryMethod = $factory->getDeliveryMethod($totalPrice);

        $this->assertInstanceOf(LowPriceDeliveryMethod::class, $deliveryMethod);
        $this->assertEquals(4.95, $deliveryMethod->getCost());
    }

    public function testGetMediumPriceDeliveryMethod(): void
    {
        $factory = new DeliveryMethodFactory();
        $totalPrice = 80.00;

        $deliveryMethod = $factory->getDeliveryMethod($totalPrice);

        $this->assertInstanceOf(MediumPriceDeliveryMethod::class, $deliveryMethod);
        $this->assertEquals(2.95, $deliveryMethod->getCost());
    }

    public function testGetHighPriceDeliveryMethod(): void
    {
        $factory = new DeliveryMethodFactory();
        $totalPrice = 100.00;

        $deliveryMethod = $factory->getDeliveryMethod($totalPrice);

        $this->assertInstanceOf(HighPriceDeliveryMethod::class, $deliveryMethod);
        $this->assertEquals(0, $deliveryMethod->getCost());
    }
}
