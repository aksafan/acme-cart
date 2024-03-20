<?php

declare(strict_types=1);

namespace App\Model\Cart\Domain\Service\Calculator;

use App\Model\CalculatorInterface;
use App\Model\Cart\Domain\Entity\Cost\Cost;
use App\Model\Cart\Domain\Entity\Cost\Discount;

/**
 * @codeCoverageIgnore
 */
final readonly class DiscountCost implements CalculatorInterface
{
    public function __construct(
        private CalculatorInterface $next
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCost(array $items): Cost
    {
        $discounts = []; // Here could be additional discount options

        $cost = $this->next->getCost($items);

        foreach ($discounts as $discount) {
            $new = new Discount($cost->value * $discount->percent / 100, $discount->name);
            $cost->addDiscount($new);
        }

        return $cost;
    }
}
