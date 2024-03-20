<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Application\UseCase\CalculateCartCost;

use App\Model\CalculatorInterface;
use App\Model\Cart\Application\UseCase\CalculateCartCost\Command;
use App\Model\Cart\Application\UseCase\CalculateCartCost\Handler;
use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Infrastructure\DataTypes\Id;
use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\DeliveryMethodFactory;
use App\Model\DeliveryMethodInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
    private CartRepositoryInterface $cartRepository;
    private CalculatorInterface $calculator;
    private Handler $handler;
    private DeliveryMethodFactory $deliveryMethodFactory;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepositoryInterface::class);
        $this->calculator = $this->createMock(CalculatorInterface::class);
        $this->deliveryMethodFactory = $this->createMock(DeliveryMethodFactory::class);
        $this->handler = new Handler($this->cartRepository, $this->calculator, $this->deliveryMethodFactory);
    }

    /**
     * @throws Exception
     */
    public function testHandle(): void
    {
        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $command = new Command(new Id($cartId));

        $cartItems = [];

        $costValue = 32.9;
        $deliveryMethodCost = 4.95;
        $currency = '$';
        $totalCartCost = round($costValue + $deliveryMethodCost, 2, PHP_ROUND_HALF_DOWN);

        $cartMock = $this->createMock(Cart::class);
        $cartMock->expects($this->once())
            ->method('getItems')
            ->willReturn($cartItems);
        $this->cartRepository->expects($this->once())
            ->method('get')
            ->with($cartId)
            ->willReturn($cartMock);

        $costMock = $this->createMock(Cost::class);
        $costMock->expects($this->once())
            ->method('getTotal')
            ->willReturn($costValue);
        $costMock->expects($this->once())
            ->method('getCurrency')
            ->willReturn($currency);
        $this->calculator->expects($this->once())
            ->method('getCost')
            ->with($cartItems)
            ->willReturn($costMock);

        $deliveryMethodMock = $this->createMock(DeliveryMethodInterface::class);
        $deliveryMethodMock->expects($this->once())
            ->method('getCost')
            ->willReturn($deliveryMethodCost);
        $this->deliveryMethodFactory->expects($this->once())
            ->method('getDeliveryMethod')
            ->willReturn($deliveryMethodMock);

        $result = $this->handler->handle($command);

        $expectedResult = sprintf('%s%s', $currency, $totalCartCost);

        $this->assertEquals($expectedResult, $result);
    }
}
