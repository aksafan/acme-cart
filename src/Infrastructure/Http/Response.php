<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class Response
{
    /**
     * @param string $content
     * @param HttpStatusCode $statusCode
     * @param string[] $headers
     */
    public function __construct(
        private string $content = '',
        private HttpStatusCode $statusCode = HttpStatusCode::OK,
        private array $headers = []
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode->value;
    }

    public function getStatusText(): string
    {
        return $this->statusCode->name;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeaders(string $header): bool
    {
        return isset($this->headers[$header]);
    }

    public function withContent(string $content): self
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    public function withStatus(HttpStatusCode $statusCode): self
    {
        $new = clone $this;
        $new->statusCode = $statusCode;

        return $new;
    }

    public function withHeader(string $header, string $value): self
    {
        $new = clone $this;
        if ($new->hasHeaders($header)) {
            unset($this->headers[$header]);
        }
        $this->headers[$header] = $value;

        return $new;
    }

    public function send(): static
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    private function sendContent(): void
    {
        echo $this->content;
    }

    private function sendHeaders(): void
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->getHeaders() as $name => $value) {
            header(sprintf('%s:%s', $name, $value));
        }
        header(
            sprintf('HTTP/1.0 %d %s', $this->getStatusCode(), $this->getStatusText()),
            true,
            $this->getStatusCode()
        );
    }
}
