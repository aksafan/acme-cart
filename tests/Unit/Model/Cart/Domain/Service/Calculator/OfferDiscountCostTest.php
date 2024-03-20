<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Service\Calculator;

use App\Infrastructure\DataTypes\Price;
use App\Model\CalculatorInterface;
use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Service\Calculator\OfferDiscountCost;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class OfferDiscountCostTest extends TestCase
{
    /**
     * @throws Exception
     */
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

        $nextCalculator = $this->createMock(CalculatorInterface::class);
        $nextCalculatorCost = new Cost(100, '$');
        $nextCalculator->expects($this->once())
            ->method('getCost')
            ->with([$item1, $item2, $item3])
            ->willReturn($nextCalculatorCost);

        $calculator = new OfferDiscountCost($nextCalculator);

        $cost = $calculator->getCost([$item1, $item2, $item3]);

        $expectedTotalCost = $nextCalculatorCost->value;

        $this->assertInstanceOf(Cost::class, $cost);
        $this->assertSame($expectedTotalCost, $cost->value);
    }
}
