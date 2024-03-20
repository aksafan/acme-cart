<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Repository;

use App\Model\Cart\Domain\Entity\Cart\Cart;
use App\Model\Cart\Domain\Entity\Cart\Id;

interface CartRepositoryInterface
{
    public function add(Cart $cart): void;

    public function get(Id $id): Cart;
}