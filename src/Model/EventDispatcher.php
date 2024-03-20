<?php

declare(strict_types=1);

namespace App\Model;

interface EventDispatcher
{
    /**
     * @param object[] $events
     *
     * @return void
     */
    public function dispatch(array $events): void;
}
