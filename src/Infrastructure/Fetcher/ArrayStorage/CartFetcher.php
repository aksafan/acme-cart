<?php

namespace App\Infrastructure\Fetcher\ArrayStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\ReadModel\Cart\CartFetcherInterface;
use Exception;

/**
 * A sample of how Fetchers could be extended
 */
final readonly class CartFetcher implements CartFetcherInterface
{
    /**
     * @param string $id
     *
     * @return Cart
     *
     * @throws Exception
     */
    public function fetch(string $id): Cart
    {
        throw new Exception('Need to implement fetch method!');
    }

    /**
     * @param string $cartId
     *
     * @return array[]
     *
     * @throws Exception
     */
    public function fetchAll(string $cartId): array
    {
        throw new Exception('Need to implement fetchAll method!');
    }
}
