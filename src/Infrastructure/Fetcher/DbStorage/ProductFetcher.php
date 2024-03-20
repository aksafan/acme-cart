<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\DbStorage;

use App\Model\Cart\Domain\Entity\Product\Product;
use App\ReadModel\NotFoundException;
use App\ReadModel\Product\ProductFetcherInterface;
use PDO;

final readonly class ProductFetcher implements ProductFetcherInterface
{
    public function __construct(
        private PDO $db
    ) {}

    public function fetch(string $id): Product
    {
        $query = '
            SELECT * 
            FROM product 
            WHERE id = ?
        ';
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        $productRow = $statement->fetch();

        if (!$productRow) {
            throw new NotFoundException('Product is not found.');
        }

        // TODO: Hydration logic is here

        return new Product();
    }
}
