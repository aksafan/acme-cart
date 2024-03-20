<?php

declare(strict_types=1);

namespace App\Infrastructure\Fetcher\DbStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\ReadModel\Cart\CartFetcherInterface;
use Exception;
use PDO;

/**
 * A sample of how Fetchers could be extended
 */
final readonly class CartFetcher implements CartFetcherInterface
{
    public function __construct(
        private PDO $db
    ) {
    }

    /**
     * @param string $cartId
     *
     * @return array[]
     */
    public function fetchAll(string $cartId): array
    {
        $query = '
            SELECT * 
            FROM cart c 
            JOIN cart_items ci on c.id = ci.cart_id
            WHERE c.id = ?
        ';
        $statement = $this->db->prepare($query);
        $statement->execute([$cartId]);

        return $statement->fetchAll();
    }

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
}
