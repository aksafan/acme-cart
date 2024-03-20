<?php

declare(strict_types=1);

namespace App\ReadModel\Product;

use App\Model\Cart\Domain\Entity\Product\Product;

interface ProductFetcherInterface
{
    public function fetch(string $id): Product;
}
