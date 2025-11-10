<?php

declare(strict_types=1);

namespace PhpCurl\Http;

use PhpCurl\Http\Method\HttpMethod;

class Request
{
    public function __construct(
        public readonly HttpMethod $method,
        public readonly string $url,
        public readonly array $headers = [],
        public readonly ?string $body = null,
    ){}
}