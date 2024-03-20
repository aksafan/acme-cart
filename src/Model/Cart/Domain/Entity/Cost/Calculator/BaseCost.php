<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Entity\Cost\Calculator;

use App\Model\CalculatorInterface;
use App\Model\Cart\Domain\Entity\Cost\Cost;

class BaseCost implements CalculatorInterface
{
    public function getCost(array $items): Cost
    {
        $cost = 0;
        $currency = '';
        foreach ($items as $item) {
            $cost += $item->getCost();
            $currency = $item->getCurrency();
        }

        return new Cost($cost, $currency);
    }
}