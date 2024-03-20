<?php

declare(strict_types=1);

namespace App\Infrastructure\Event\Dispatcher\Message;

final readonly class Message
{
    public function __construct(
        private object $event
    ) {
    }

    public function getEvent(): object
    {
        return $this->event;
    }
}
