<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Product;

use Webmozart\Assert\Assert;

final readonly class Price
{
    private const CURRENCIES = [
        '$',
        '€'
    ];
    public function __construct(
        public float $amount,
        public string $currency
    ) {
        Assert::inArray($this->currency, self::CURRENCIES);
    }
}
