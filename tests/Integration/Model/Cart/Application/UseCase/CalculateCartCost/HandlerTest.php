<?php

declare(strict_types=1);

namespace Integration\Model\Cart\Application\UseCase\CalculateCartCost;

use App\Infrastructure\DataTypes\Id;
use App\Model\Cart\Application\UseCase\CalculateCartCost\Command;
use App\Model\Cart\Application\UseCase\CalculateCartCost\Handler;
use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\Cart\Domain\Service\Calculator\BaseCost;
use App\Model\Cart\Domain\Service\Calculator\DiscountCost;
use App\Model\Cart\Domain\Service\Calculator\OfferDiscountCost;
use App\Model\DeliveryMethodFactory;
use App\Infrastructure\DataTypes\Price;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(Handler::class)]
class HandlerTest extends TestCase
{
    private Handler $handler;
    private CartRepositoryInterface $cartRepository;

    public static function cartsProvider(): array
    {
        return [
            'B01, G01' => [
                '7d527665-735e-420c-9ab7-4ee0402df7e7',
                [
                    'Items' => [
                        '02188fb5-5da8-4b00-b6e3-8448db24ec28' => [
                            'Quantity' => 1,
                            [
                                'Product' => 'Blue Widget',
                                'Code' => 'B01',
                                'Price' => 7.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                        '036359c2-cb28-45d6-b399-7d68f7a06b1a' => [
                            'Quantity' => 1,
                            [
                                'Product' => 'Green Widget',
                                'Code' => 'G01',
                                'Price' => 24.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                    ],
                ],
                '$37.85',
            ],
            'R01, R01' => [
                'c6a98462-c580-40b5-b90c-b99920f2b344',
                [
                    'Items' => [
                        'f480859a-d506-434f-b918-891c2d178a2b' => [
                            'Quantity' => 2,
                            [
                                'Product' => 'Red Widget',
                                'Code' => 'R01',
                                'Price' => 32.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                    ],
                ],
                '$54.37',
            ],
            'R01, G01' => [
                '97c69798-8389-4b55-a291-01465c014df8',
                [
                    'Items' => [
                        'f480859a-d506-434f-b918-891c2d178a2b' => [
                            'Quantity' => 1,
                            [
                                'Product' => 'Red Widget',
                                'Code' => 'R01',
                                'Price' => 32.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                        '036359c2-cb28-45d6-b399-7d68f7a06b1a' => [
                            'Quantity' => 1,
                            [
                                'Product' => 'Green Widget',
                                'Code' => 'G01',
                                'Price' => 24.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                    ],
                ],
                '$60.85',
            ],
            'B01, B01, R01, R01, R01' => [
                '660a88c5-3626-4f51-bb6f-2c63d941a494',
                [
                    'Items' => [
                        '02188fb5-5da8-4b00-b6e3-8448db24ec28' => [
                            'Quantity' => 2,
                            [
                                'Product' => 'Blue Widget',
                                'Code' => 'B01',
                                'Price' => 7.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                        'f480859a-d506-434f-b918-891c2d178a2b' => [
                            'Quantity' => 3,
                            [
                                'Product' => 'Red Widget',
                                'Code' => 'R01',
                                'Price' => 32.95,
                                'Currency' => '$',
                                'Quantity' => 22,
                            ],
                        ],
                    ],
                ],
                '$98.27',
            ],
        ];
    }

    #[DataProvider('cartsProvider')]
    public function testHandle(string $cartId, array $cartData, string $expected): void
    {
        $cartItems = [];

        foreach ($cartData['Items'] as $productId => $item) {
            $cartItem = new CartItem(
                productCode: $item[0]['Code'],
                quantity: $item['Quantity'],
                price: new Price((float)$item[0]['Price'], $item[0]['Currency']),
            );
            $cartItems[] = $cartItem;
        }

        $id = new Id($cartId);
        $cart = new Cart(
            id: $id,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: $cartItems,
        );

        $this->cartRepository->expects($this->once())
            ->method('get')
            ->with($cartId)
            ->willReturn($cart);

        $command = new Command($id);

        $result = $this->handler->handle($command);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepositoryInterface::class);
        $calculator = new DiscountCost(new OfferDiscountCost(new BaseCost()));
        $deliveryMethodFactory = new DeliveryMethodFactory();
        $this->handler = new Handler($this->cartRepository, $calculator, $deliveryMethodFactory);
    }
}
