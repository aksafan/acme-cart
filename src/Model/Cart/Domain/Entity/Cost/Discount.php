<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cost;

final readonly class Discount
{
    public function __construct(
        public float $value,
        public string $name,
    ) {
    }
}
