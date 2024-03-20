<?php

declare(strict_types=1);

namespace App\Model\Product\Domain\Entity\Product;

use App\Infrastructure\DataTypes\Id;
use App\Infrastructure\DataTypes\Price;
use App\Model\AggregateRoot;
use App\Model\Cart\Domain\Entity\Event\ProductOutOfStock;
use DateTimeImmutable;
use DomainException;

final class Product implements AggregateRoot
{
    /** @var object[] $events */
    private array $events = [];

    public function __construct(
        public readonly Id $id,
        public readonly DateTimeImmutable $date,
        public readonly string $code,
        public readonly string $name,
        public readonly Price $price,
        private int $quantity
    ) {
    }

    public function canBeCheckout(int $quantity): bool
    {
        return $quantity <= $this->quantity;
    }

    public function checkout(int $quantity): void
    {
        if ($quantity > $this->quantity) {
            throw new DomainException(sprintf('Only %d items are available.', $this->quantity));
        }
        $this->setQuantity($this->quantity - $quantity);
    }

    public function getCurrency(): string
    {
        return $this->price->currency;
    }

    public function getPriceAmount(): float
    {
        return $this->price->amount;
    }

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    private function recordEvent(object $event): void
    {
        $this->events[] = $event;
    }

    private function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        if (0 === $quantity) {
            $this->recordEvent(new ProductOutOfStock($this));
        }
    }
}
