<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class ResourceTestCase extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    protected array $history = [];

    /**
     * @param list<Response> $responses
     */
    protected function makeClient(array $responses): Client
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);

        return new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);
    }

    /**
     * @return array<string, mixed>
     */
    protected function lastRequestBody(): array
    {
        /** @var array<string, mixed> */
        return json_decode((string) $this->history[0]['request']->getBody(), true);
    }

    protected function lastRequestMethod(): string
    {
        return $this->history[0]['request']->getMethod();
    }

    protected function lastRequestPath(): string
    {
        return $this->history[0]['request']->getUri()->getPath();
    }
}
