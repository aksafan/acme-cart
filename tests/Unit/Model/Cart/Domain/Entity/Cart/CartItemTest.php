<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Entity\Cart;

use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Infrastructure\DataTypes\Price;
use PHPUnit\Framework\TestCase;

class CartItemTest extends TestCase
{
    public function testConstructor(): void
    {
        $productCode = 'B01';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $this->assertSame($productCode, $cartItem->productCode);
        $this->assertSame(3, $cartItem->quantity);
    }

    public function testGetProductId(): void
    {
        $productCode = 'B01';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $this->assertSame($productCode, $cartItem->productCode);
    }

    public function testGetProductCode(): void
    {
        $productCode = 'B01';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: $productCode,
            quantity: $quantity,
            price: new Price(7.95, '$')
        );

        $this->assertSame($productCode, $cartItem->productCode);
    }

    public function testGetCost(): void
    {
        $productPrice = 7.95;
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: 'B01',
            quantity: $quantity,
            price: new Price($productPrice, '$')
        );

        $this->assertSame($productPrice * $quantity, $cartItem->getCost());
    }

    public function testGetCurrency(): void
    {
        $productCurrency = '$';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: 'B01',
            quantity: $quantity,
            price: new Price(7.95, $productCurrency)
        );

        $this->assertSame($productCurrency, $cartItem->getCurrency());
    }

    public function testAddQuantity(): void
    {
        $productCurrency = '$';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: 'B01',
            quantity: $quantity,
            price: new Price(7.95, $productCurrency)
        );

        $newQuantity = 2;
        $newCartItem = $cartItem->addQuantity($newQuantity);

        $this->assertSame($quantity + $newQuantity, $newCartItem->quantity);
    }

    public function testChangeQuantity(): void
    {
        $productCurrency = '$';
        $quantity = 3;
        $cartItem = new CartItem(
            productCode: 'B01',
            quantity: $quantity,
            price: new Price(7.95, $productCurrency)
        );

        $newQuantity = 2;
        $newCartItem = $cartItem->changeQuantity($newQuantity);

        $this->assertSame($newQuantity, $newCartItem->quantity);
    }
}
