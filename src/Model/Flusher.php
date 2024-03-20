<?php

declare(strict_types=1);

namespace App\Model;

/**
 * @codeCoverageIgnore
 */
final readonly class Flusher
{
    public function __construct(
        private EventDispatcher $dispatcher
    ) {
    }

    public function flush(AggregateRoot ...$roots): void
    {
        // TODO: Implement EM/File/etc flushing logic
        // $this->em->flush();

        foreach ($roots as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
        }
    }
}
