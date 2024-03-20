<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cart;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class Id
{
    public function __construct(
        private string $value
    ) {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
