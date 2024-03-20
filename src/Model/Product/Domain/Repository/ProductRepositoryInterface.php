<?php

declare(strict_types=1);

namespace App\Model\Product\Domain\Repository;

use App\Infrastructure\DataTypes\Id;
use App\Model\Product\Domain\Entity\Product\Product;

interface ProductRepositoryInterface
{
    public function get(Id $id): Product;

    public function getByCode(string $code): Product;
}
