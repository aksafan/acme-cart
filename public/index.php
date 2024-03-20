<?php

use App\Infrastructure\Http\HttpStatusCode;

require_once dirname(__DIR__).'/vendor/autoload.php';

function exception_handler(Throwable $exception): void {
    http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR->value);
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
