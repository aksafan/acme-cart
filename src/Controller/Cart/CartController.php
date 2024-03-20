<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Infrastructure\Http\HttpStatusCode;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Http\Response;
use App\Model\Cart\Application\UseCase\CalculateCartCost;
use App\Infrastructure\DataTypes\Id;

readonly class CartController
{
    public function __construct(
        private Request $request
    ) {
    }

    public function actionCalculate(CalculateCartCost\Handler $handler): Response
    {
        $query = $this->request->getQueryParams();
        // TODO: add validation here
        $command = new CalculateCartCost\Command(new Id($query['id']));
        $totalCartCost = $handler->handle($command);

        return new Response(sprintf('Total Cart Cost is %s', $totalCartCost), HttpStatusCode::OK);
    }
}
