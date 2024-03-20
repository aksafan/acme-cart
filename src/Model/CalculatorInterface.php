<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Cart\Domain\Entity\Cart\CartItem;
use App\Model\Cart\Domain\Entity\Cost\Cost;

interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items): Cost;
} 