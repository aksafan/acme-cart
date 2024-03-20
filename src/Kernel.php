<?php

declare(strict_types=1);

namespace App;

use App\Controller\Cart\CartController;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\RequestFactory;
use App\Infrastructure\Repository\ArrayStorage\CartRepository;
use App\Model\Cart\Application\UseCase\CalculateCartCost;
use App\Model\Cart\Domain\Service\Calculator\BaseCost;
use App\Model\Cart\Domain\Service\Calculator\DiscountCost;
use App\Model\Cart\Domain\Service\Calculator\OfferDiscountCost;
use App\Model\DeliveryMethodFactory;

class Kernel
{
    public function run(): int
    {
        $request = RequestFactory::createFromGlobals();

        // TODO: Implement proper router here
        preg_match('/^\/(?P<route>\w+)\?/', $_SERVER['REQUEST_URI'], $matches);
        $route = $matches['route'] ?? null;
        if ('calculate' === $route) {
            return $this->handleCalculate($request);
        }

        return 0;
    }

    private function handleCalculate(Request $request): int
    {
        $controller = new CartController($request);
        $cartRepository = new CartRepository();
        $calculator = new DiscountCost(new OfferDiscountCost(new BaseCost()));
        $deliveryMethodFactory = new DeliveryMethodFactory();
        $handler = new CalculateCartCost\Handler($cartRepository, $calculator, $deliveryMethodFactory);
        $response = $controller->actionCalculate($handler);
        $response->send();

        return 0;
    }
}
