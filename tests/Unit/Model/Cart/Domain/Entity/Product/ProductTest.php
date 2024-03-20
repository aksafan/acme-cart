<?php

declare(strict_types=1);

namespace Unit\Model\Cart\Domain\Entity\Product;

use App\Infrastructure\DataTypes\Id;
use App\Infrastructure\DataTypes\Price;
use App\Model\Product\Domain\Entity\Event\ProductOutOfStock;
use App\Model\Product\Domain\Entity\Product\Product;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCanBeCheckout(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $price = new Price(7.95, '$');
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: 22
        );

        $this->assertTrue($product->canBeCheckout(3));
        $this->assertFalse($product->canBeCheckout(23));
    }

    public function testCheckout(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $price = new Price(7.95, '$');
        $quantity = 22;
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: $quantity
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(sprintf('Only %d items are available.', $quantity));

        $product->checkout(23);
    }

    public function testGetCurrency(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $currency = '$';
        $price = new Price(7.95, $currency);
        $quantity = 22;
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: $quantity
        );

        $this->assertSame($currency, $product->getCurrency());
    }

    public function testGetPriceAmount(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $priceAmount = 7.95;
        $price = new Price($priceAmount, '$');
        $quantity = 22;
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: $quantity
        );
        $this->assertSame($priceAmount, $product->getPriceAmount());
    }

    public function testReleaseEvents(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $price = new Price(7.95, '$');
        $quantity = 22;
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: $quantity
        );

        $events = $product->releaseEvents();
        $this->assertEmpty($events);
    }

    public function testRecordEvent(): void
    {
        $productId = '02188fb5-5da8-4b00-b6e3-8448db24ec28';
        $productIdObject = new Id($productId);
        $price = new Price(7.95, '$');
        $quantity = 22;
        $product = new Product(
            id: $productIdObject,
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: 'B01',
            name: 'Blue Widget',
            price: $price,
            quantity: $quantity
        );

        $product->checkout($quantity);

        $events = $product->releaseEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(ProductOutOfStock::class, $events[0]);
    }
}
