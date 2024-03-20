<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

final readonly class Request
{
    /**
     * @param string[] $queryParams
     * @param string[] $bodyParams
     */
    public function __construct(
        private array $queryParams,
        private array $bodyParams,
    ) {
    }

    /**
     * @return string[]
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return string[]
     */
    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }
}
