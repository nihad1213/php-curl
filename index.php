<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use PhpCurl\Http\Client;
use PhpCurl\Http\Method\HttpMethod;
use PhpCurl\Http\Request;

echo "Starting test..." . PHP_EOL;

$client = new Client();

$response = $client->get('https://jsonplaceholder.typicode.com/posts/1');

echo "Status: " . $response->status . PHP_EOL;
echo "Body: " . $response->body . PHP_EOL;
