<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class RequestFactory
{
    /**
     * @param string[]|null $queryParams
     * @param string[]|null $bodyParams
     *
     * @return Request
     */
    public static function createFromGlobals(?array $queryParams = null, ?array $bodyParams = null): Request
    {
        return new Request($queryParams ?? $_GET, $bodyParams ?? $_POST);
    }
}
