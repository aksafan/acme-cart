<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Event;

use App\Model\Cart\Domain\Entity\Product\Product;

/**
 * @codeCoverageIgnore
 */
final readonly class ProductOutOfStock
{
    public function __construct(
        Product $product
    ) {
    }
}