<?php

namespace App\Infrastructure\Fetcher\ArrayStorage;

use App\Model\Cart\Domain\Entity\Product\Id;
use App\Model\Cart\Domain\Entity\Product\Price;
use App\Model\Cart\Domain\Entity\Product\Product;
use App\Model\EntityNotFoundException;
use App\ReadModel\Product\ProductFetcherInterface;
use DateTimeImmutable;

class ProductFetcher implements ProductFetcherInterface
{
    private const PRODUCT_DATA = [
        'f480859a-d506-434f-b918-891c2d178a2b' => [
            'Product' => 'Red Widget',
            'Code' => 'R01',
            'Price' => 32.95,
            'Currency' => '$',
            'Quantity' => 22,
        ],
        '036359c2-cb28-45d6-b399-7d68f7a06b1a' => [
            'Product' => 'Green Widget',
            'Code' => 'G01',
            'Price' => 24.95,
            'Currency' => '$',
            'Quantity' => 22,
        ],
        '02188fb5-5da8-4b00-b6e3-8448db24ec28' => [
            'Product' => 'Blue Widget',
            'Code' => 'B01',
            'Price' => 7.95,
            'Currency' => '$',
            'Quantity' => 22,
        ],
    ];

    public function fetch(string $id): Product
    {
        if (empty($productDatum = self::PRODUCT_DATA[$id])) {
            throw new EntityNotFoundException('Product is not found.');
        }

        return new Product(
            id: new Id($id),
            date: new DateTimeImmutable('2000-01-01 00:00:00-05:00'),
            code: $productDatum['Code'],
            name: $productDatum['Product'],
            price: new Price($productDatum['Price'], $productDatum['Currency']),
            quantity: $productDatum['Quantity']
        );
    }
}