<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\DbStorage;

use App\Model\Cart\Domain\Entity\Product\Product;
use App\ReadModel\NotFoundException;
use App\ReadModel\Product\ProductFetcherInterface;
use Exception;

/**
 * A sample of how Fetchers could be extended
 */
final readonly class ProductFetcher implements ProductFetcherInterface
{
    public function __construct()
    {
    }

    /**
     * @param string $id
     *
     * @return Product
     *
     * @throws NotFoundException|Exception
     */
    public function fetch(string $id): Product
    {
        throw new Exception('Need to implement fetch method!');
    }
}
