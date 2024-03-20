<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Service\Calculator;

use App\Infrastructure\DataTypes\Price;
use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Service\Calculator\BaseCost;
use PHPUnit\Framework\TestCase;

class BaseCostTest extends TestCase
{
    public function testGetCost(): void
    {
        $productCode1 = 'R01';
        $quantity1 = 3;
        $price1 = 32.95;
        $item1 = new CartItem(
            productCode: $productCode1,
            quantity: $quantity1,
            price: new Price($price1, '$')
        );
        $productCode2 = 'G01';
        $quantity2 = 4;
        $price2 = 24.95;
        $item2 = new CartItem(
            productCode: $productCode2,
            quantity: $quantity2,
            price: new Price($price2, '$')
        );
        $productCode3 = 'B01';
        $quantity3 = 5;
        $price3 = 7.95;
        $item3 = new CartItem(
            productCode: $productCode3,
            quantity: $quantity3,
            price: new Price($price3, '$')
        );

        $calculator = new BaseCost();

        $cost = $calculator->getCost([$item1, $item2, $item3]);

        $expectedTotalCost = $price1 * $quantity1 + $price2 * $quantity2 + $price3 * $quantity3;

        $this->assertInstanceOf(Cost::class, $cost);
        $this->assertSame($expectedTotalCost, $cost->value);
        $this->assertSame('$', $cost->getCurrency());
    }
}
