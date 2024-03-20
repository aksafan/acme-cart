<?php

declare(strict_types=1);

namespace App\Model\Product\Domain\Entity\Event;

use App\Model\Product\Domain\Entity\Product\Product;

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
