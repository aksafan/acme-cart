<?php

namespace App\Infrastructure\Fetcher\ArrayStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\ReadModel\Cart\CartFetcherInterface;

final readonly class CartFetcher implements CartFetcherInterface
{
    public function fetch(string $id): Cart
    {
    }

    public function fetchAll(string $cartId): array
    {
    }
}
