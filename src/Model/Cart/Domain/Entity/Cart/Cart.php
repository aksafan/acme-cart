<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cart;

use App\Infrastructure\DataTypes\Id;
use DateTimeImmutable;
use DomainException;

class Cart
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
            if ($current->getProductCode() === $item->getProductCode()) {
                $this->items[$i] = $current->addQuantity($item->quantity);
                return;
            }
        }
        $this->items[] = $item;
    }

    public function changeQuantity(string $productCode, int $quantity): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getProductCode() === $productCode) {
                $this->items[$i] = $current->changeQuantity($quantity);
                return;
            }
        }
        throw new DomainException('CartItem is not found.');
    }

    public function remove(string $productCode): void
    {
        foreach ($this->items as $i => $current) {
            if ($current->getProductCode() === $productCode) {
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
}
