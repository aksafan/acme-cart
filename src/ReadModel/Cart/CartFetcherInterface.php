<?php

declare(strict_types=1);

namespace App\ReadModel\Cart;

use App\Model\Cart\Domain\Entity\Cart\Cart;

interface CartFetcherInterface
{
    public function fetch(string $id): Cart;

    public function fetchAll(string $cartId): array;
}
