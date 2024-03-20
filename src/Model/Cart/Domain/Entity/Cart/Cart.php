<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cart;

use App\Model\AggregateRoot;
use App\Model\Cart\Domain\Entity\Product\Id as ProductId;
use DateTimeImmutable;
use DomainException;

class Cart implements AggregateRoot
{
    public function __construct(
        public readonly Id $id,
        public readonly DateTimeImmutable $date,
        /** @var CartItem[] $items */
        private array $items,
    ) {
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function add(CartItem $item): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getProductId() === $item->getProductId()) {
                $this->items[$i] = $current->addQuantity($item->quantity);
                return;
            }
        }
        $this->items[] = $item;
    }

    public function changeQuantity(ProductId $id, int $quantity): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getProductId() === $id) {
                $this->items[$i] = $current->changeQuantity($quantity);
                return;
            }
        }
        throw new DomainException('CartItem is not found.');
    }

    public function remove(ProductId $id): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getProductId() === $id) {
                unset($this->items[$i]);
                return;
            }
        }
        throw new DomainException('CartItem is not found.');
    }

    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function releaseEvents(): array
    {
    }
}
