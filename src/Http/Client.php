<?php

namespace PhpCurl\Http;

use PhpCurl\Exception\CurlException;
use PhpCurl\Http\Method\HttpMethod;

class Client
{
    public function send(Request $request): Response
    {
        $curl = curl_init($request->url);

        if (!$curl) {
            throw new CurlException("Failed to initialize cURL");
        }

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->method->value);

        if (!empty($request->headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $request->headers);
        }

        if (in_array($request->method, [HttpMethod::POST, HttpMethod::PUT, HttpMethod::PATCH]) 
            && $request->body !== null
        ) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request->body);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $body = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        $errno = curl_errno($curl);

        curl_close($curl);

        if ($errno) {
            throw new CurlException("cURL error ({$errno}): {$error}", $errno);
        }

        return new Response(
            statusCode: $status,
            status: curl_getinfo($curl, CURLINFO_HTTP_CODE) . ' OK',
            headers: [],
            body: $body
        );
    }

    public function get(string $url, array $headers = []): Response
    {
        $request = new Request(HttpMethod::GET, $url, $headers);
        return $this->send($request);
    }

    public function post(string $url, array $headers = [], ?string $body = null): Response
    {
        $request = new Request(HttpMethod::POST, $url, $headers, $body);
        return $this->send($request);
    }

    public function put(string $url, array $headers = [], ?string $body = null): Response
    {
        $request = new Request(HttpMethod::PUT, $url, $headers, $body);
        return $this->send($request);
    }

    public function patch(string $url, array $headers = [], ?string $body = null): Response
    {
        $request = new Request(HttpMethod::PATCH, $url, $headers, $body);
        return $this->send($request);
    }

    public function delete(string $url, array $headers = []): Response
    {
        $request = new Request(HttpMethod::DELETE, $url, $headers);
        return $this->send($request);
    }
}
