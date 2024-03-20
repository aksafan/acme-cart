<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Entity\Cart;

use App\Infrastructure\DataTypes\Id;
use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Infrastructure\DataTypes\Price;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAddCartItem(): void
    {
        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [],
        );

        $productCode = 'B01';
        $quantity = 2;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cart->add($cartItem);

        $items = $cart->getItems();
        $this->assertCount(1, $items);
    }

    public function testAddCartItemWithAlreadyExistedInCartSameItem(): void
    {
        $productCode = 'B01';
        $quantity = 2;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $cart->add($cartItem);

        $items = $cart->getItems();
        $this->assertCount(1, $items);
        $this->assertSame($quantity + $quantity, $items[0]->quantity);
    }

    public function testAddCartItemWithAlreadyExistedInCartDifferentItem(): void
    {
        $productCode = 'G01';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(24.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $anotherQuantity = 5;
        $anotherCartItem = new CartItem(
            productCode: 'B01',
            quantity: $anotherQuantity,
            price: new Price(7.95, '$')
        );

        $cart->add($anotherCartItem);

        $items = $cart->getItems();
        $this->assertCount(2, $items);
        $this->assertSame($quantity + $anotherQuantity, $items[0]->quantity + $items[1]->quantity);
    }

    public function testChangeCartItemQuantity(): void
    {
        $productCode = 'B01';
        $quantity = 1;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $newQuantity = 5;
        $cart->changeQuantity($productCode, $newQuantity);

        $items = $cart->getItems();
        $this->assertCount(1, $items);
        $this->assertSame($newQuantity, $items[0]->quantity);
    }

    public function testChangeCartItemQuantityWithWrongCartItem(): void
    {
        $productCode = 'B01';
        $quantity = 1;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('CartItem is not found.');

        $newQuantity = 5;
        $cart->changeQuantity('wrong_code', $newQuantity);
    }

    public function testRemoveCartItem(): void
    {
        $productCode = 'B01';
        $quantity = 1;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $cart->remove($productCode);

        $items = $cart->getItems();
        $this->assertCount(0, $items);
    }

    public function testRemoveCartItemWithWrongCartItem(): void
    {
        $productCode = 'B01';
        $quantity = 1;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('CartItem is not found.');

        $cart->remove('wrong_code');
    }

    public function testClearCart(): void
    {
        $productCode = 'B01';
        $quantity = 1;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $cartId = '7d527665-735e-420c-9ab7-4ee0402df7e7';
        $cart = new Cart(
            id: new Id($cartId),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            items: [$cartItem]
        );

        $cart->clear();

        $items = $cart->getItems();
        $this->assertCount(0, $items);
    }
}
