<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Service\Calculator;

use App\Model\CalculatorInterface;
use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Entity\Cost\Discount;

final readonly class OfferDiscountCost implements CalculatorInterface
{
    public function __construct(
        private CalculatorInterface $next
    ) {
    }

    public function getCost(array $items): Cost
    {
        $totalOfferDiscount = 0;
        $cost = $this->next->getCost($items);

        // Could be an overhead at the first glance and should be moved to BaseCost item iteration part
        // But extracting this logic to OfferCost will help to add more offers in the future
        // without digging into BaseCost logic
        foreach ($items as $item) {
            if ($item->productCode === 'R01' && $item->quantity > 1) { // TODO: replace `R01` with entity
                $itemsWithOffer = round($item->quantity / 2, 0, PHP_ROUND_HALF_DOWN);
                $offerDiscount = $item->getPriceAmount() * 50 / 100;  // TODO: replace 50 with entity
                $totalOfferDiscount += $itemsWithOffer * $offerDiscount;
                $new = new Discount($totalOfferDiscount, 'OfferDiscountCost');
                $cost->addDiscount($new);
            }
        }

        return $cost;
    }
}
