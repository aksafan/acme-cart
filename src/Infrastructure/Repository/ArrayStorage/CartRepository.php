<?php

namespace App\Infrastructure\Repository\ArrayStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Entity\Cart\Id;
use App\Model\Cart\Domain\Entity\Product\Id as ProductId;
use App\Model\Cart\Domain\Entity\Product\Price;
use App\Model\Cart\Domain\Entity\Product\Product;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\EntityNotFoundException;
use DateTimeImmutable;

final readonly class CartRepository implements CartRepositoryInterface
{
    private const CART_DATA = [
        '7d527665-735e-420c-9ab7-4ee0402df7e7' => [
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
        'c6a98462-c580-40b5-b90c-b99920f2b344' => [
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
        '97c69798-8389-4b55-a291-01465c014df8' => [
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
        '660a88c5-3626-4f51-bb6f-2c63d941a494' => [
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
    ];

    public function get(Id $id): Cart
    {
        $cartDatum = self::CART_DATA[$id->getValue()] ?? null;
        if (!$cartDatum) {
            throw new EntityNotFoundException('Cart is not found.');
        }

        $cartItems = [];

        foreach ($cartDatum['Items'] as $productId => $item) {
            $product = new Product(
                id: new ProductId($productId),
                date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
                code: $item[0]['Code'],
                name: $item[0]['Product'],
                price: new Price($item[0]['Price'], $item[0]['Currency']),
                quantity: $item[0]['Quantity']
            );
            $cartItem = new CartItem(
                product: $product,
                quantity: $item['Quantity']
            );
            $cartItems[] = $cartItem;
        }


        return new Cart(
            id: $id,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: $cartItems,
        );
    }

    public function add(Cart $cart): void
    {
    }
}
