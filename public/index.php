<?php

use App\Infrastructure\Http\HttpStatusCode;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once dirname(__DIR__) . '/vendor/autoload.php';

function exception_handler(Throwable $exception): void
{
    http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR->value);
    $logger = new Logger('exception_handler');
    $logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/var/log/error.log'));
    $logger->error(
        $exception->getMessage(),
        [
            'category' => 'uncaught_exception',
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
        ]
    );

    if (getenv('APP_ENV') === 'dev') {
        echo sprintf('Uncaught exception: %s.%s', $exception->getMessage(), PHP_EOL);
        print_r($exception->getTrace());
    } else {
        echo "Something went wrong \n";
    }
}

set_exception_handler('exception_handler');

$app = new App\Kernel();

$app->run();
