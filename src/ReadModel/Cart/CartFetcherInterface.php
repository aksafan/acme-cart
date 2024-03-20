<?php

declare(strict_types=1);

namespace App\ReadModel\Cart;

use App\Model\Cart\Domain\Entity\Cart\Cart;

interface CartFetcherInterface
{
    public function fetch(string $id): Cart;

    /**
     * @param string $cartId
     *
     * @return array[]
     */
    public function fetchAll(string $cartId): array;
}
