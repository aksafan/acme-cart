<?php

declare(strict_types=1);

namespace App\Infrastructure\Event\Dispatcher;

use App\Model\EventDispatcher;

final readonly class MessengerEventDispatcher implements EventDispatcher
{
    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            // TODO: Implement event dispatch logic here
            // $this->bus->dispatch(new \App\Event\Dispatcher\Message\Message($event));
        }
    }
}
