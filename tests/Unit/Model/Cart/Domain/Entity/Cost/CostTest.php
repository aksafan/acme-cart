<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Entity\Cost;

use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Entity\Cost\Discount;
use PHPUnit\Framework\TestCase;

class CostTest extends TestCase
{
    public function testConstructor(): void
    {
        $costValue = 50.0;
        $currency = '$';

        $cost = new Cost($costValue, $currency);

        $this->assertSame($costValue, $cost->value);
        $this->assertSame($currency, $cost->getCurrency());
    }

    public function testGetTotal(): void
    {
        $costValue = 50.0;
        $discountValue = 10.0;
        $currency = '$';

        $cost = new Cost($costValue, $currency);
        $discount = new Discount($discountValue, 'name');
        $cost->addDiscount($discount);

        $expectedTotal = $costValue - $discountValue;

        $this->assertSame($expectedTotal, $cost->getTotal());
    }

    public function testGetCurrency(): void
    {
        $currency = '$';
        $cost = new Cost(50.0, $currency);

        $this->assertSame($currency, $cost->getCurrency());
    }
}
