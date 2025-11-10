<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PhpCurl\Http\Client;

final class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client();
    }

    public function testGetRequest(): void
    {
        $response = $this->client->get('https://jsonplaceholder.typicode.com/posts/1');

        $body = $response->body;
        $data = json_decode($body, true);

        $this->assertIsArray($data);
        $this->assertSame(1, $data['id']);
        $this->assertSame(1, $data['userId']);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('body', $data);

        $this->assertEquals(200, $response->statusCode);
    }

    public function testPostRequest(): void
    {
        $payload = [
            'title' => 'Test',
            'body' => 'Hello World',
            'userId' => 1,
        ];

        $response = $this->client->post(
            'https://jsonplaceholder.typicode.com/posts',
            ['Content-Type: application/json'],
            json_encode($payload)
        );

        $body = $response->body;
        $data = json_decode($body, true);

        $this->assertIsArray($data);
        $this->assertSame('Test', $data['title']);
        $this->assertSame('Hello World', $data['body']);
        $this->assertSame(1, $data['userId']);
        $this->assertArrayHasKey('id', $data);

        $this->assertEquals(201, $response->statusCode);
    }
}
