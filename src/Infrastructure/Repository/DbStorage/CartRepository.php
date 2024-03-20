<?php

namespace App\Infrastructure\Repository\DbStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\Id;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\EntityNotFoundException;
use PDO;

/**
 * A sample of how Repos could be extended
 */
final readonly class CartRepository implements CartRepositoryInterface
{
    public function __construct(
        private PDO $db
    ) {}

    public function add(Cart $cart): void {}

    public function get(Id $id): Cart
    {
        $query = '
            SELECT * 
            FROM cart c 
            JOIN cart_items ci on c.id = ci.cart_id
            JOIN product p on p.id = ci.item_id 
            WHERE c.id = ?
        ';
        $statement = $this->db->prepare($query);
        $statement->execute([$id->getValue()]);
        $cartRow = $statement->fetchAll();
        if (!$cartRow) {
            throw new EntityNotFoundException('Cart is not found.');
        }

        // TODO: Hydration logic is here

        return new Cart();
    }
}