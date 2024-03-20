<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Repository;

use App\Model\Cart\Domain\Entity\Product\Id;
use App\Model\Cart\Domain\Entity\Product\Product;

interface ProductRepositoryInterface
{
    public function get(Id $id): Product;

    public function getByCode(string $code): Product;
}
