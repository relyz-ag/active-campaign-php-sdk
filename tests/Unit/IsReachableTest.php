<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit;

use ActiveCampaign\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class IsReachableTest extends TestCase
{
    public function testReturnsTrueWhenApiRespondsSuccessfully(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"user":{"id":1}}'),
        ]);

        $this->assertTrue($client->isReachable());
    }

    public function testReturnsFalseOnAuthenticationError(): void
    {
        $client = $this->makeClient([
            new Response(401, [], '{"message":"Unauthorized"}'),
        ]);

        $this->assertFalse($client->isReachable());
    }

    public function testReturnsFalseOnServerError(): void
    {
        $client = $this->makeClient([
            new Response(500, [], '{"message":"Internal Server Error"}'),
        ]);

        $this->assertFalse($client->isReachable());
    }

    public function testReturnsFalseOnNetworkError(): void
    {
        $failingClient = new class () implements ClientInterface {
            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                throw new class ('Connection refused') extends \RuntimeException implements ClientExceptionInterface {};
            }
        };

        $client = new Client(
            url: 'https://test.api-us1.com',
            apiKey: 'test-key',
            httpClient: $failingClient,
        );

        $this->assertFalse($client->isReachable());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeClient(array $responses): Client
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $stack]);

        return new Client(
            url: 'https://test.api-us1.com',
            apiKey: 'test-key',
            httpClient: $guzzle,
        );
    }
}
