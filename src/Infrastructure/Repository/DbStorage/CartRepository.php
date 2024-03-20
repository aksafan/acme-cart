<?php

namespace App\Infrastructure\Repository\DbStorage;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Infrastructure\DataTypes\Id;
use App\Model\Cart\Domain\Repository\CartRepositoryInterface;
use App\Model\EntityNotFoundException;
use Exception;

/**
 * A sample of how Repos could be extended
 */
final readonly class CartRepository implements CartRepositoryInterface
{
    public function __construct()
    {
    }

    public function add(Cart $cart): void
    {
    }

    /**
     * @param Id $id
     *
     * @return Cart
     *
     * @throws EntityNotFoundException|Exception
     */
    public function get(Id $id): Cart
    {
        throw new Exception('Need to implement get method!');
    }
}
