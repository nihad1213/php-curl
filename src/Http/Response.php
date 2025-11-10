<?php

declare(strict_types=1);

namespace PhpCurl\Http;

class Response
{
    public function __construct(
        public readonly int $statusCode,
        public readonly array $headers = [],
        public readonly ?string $body = null,
    ){}
}