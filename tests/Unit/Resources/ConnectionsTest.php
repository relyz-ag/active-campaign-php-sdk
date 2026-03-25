<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Connection;
use ActiveCampaign\Sdk\Resources\Connections;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ConnectionsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListConnections(): void
    {
        $connections = $this->makeConnections([
            new Response(200, [], (string) json_encode([
                'connections' => [
                    ['id' => '1', 'service' => 'shopify', 'externalid' => 'ext-1', 'name' => 'Store', 'status' => '1', 'logoUrl' => '', 'linkUrl' => '', 'isInternal' => '0', 'cdate' => '2024-01-01', 'udate' => '2024-01-01'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $connections->list();

        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(Connection::class, $result->data[0]);
        $this->assertSame('shopify', $result->data[0]->service);
    }

    public function testGetConnection(): void
    {
        $connections = $this->makeConnections([
            new Response(200, [], (string) json_encode([
                'connection' => ['id' => '1', 'service' => 'shopify', 'externalid' => 'ext-1', 'name' => 'Store', 'status' => '1', 'logoUrl' => '', 'linkUrl' => '', 'isInternal' => '0', 'cdate' => '2024-01-01', 'udate' => '2024-01-01'],
            ])),
        ]);

        $connection = $connections->get(1);

        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertSame(1, $connection->id);
    }

    public function testCreateConnection(): void
    {
        $connections = $this->makeConnections([
            new Response(201, [], (string) json_encode([
                'connection' => ['id' => '1', 'service' => 'shopify', 'externalid' => 'ext-1', 'name' => 'Store', 'status' => '1', 'logoUrl' => 'https://example.com/logo.png', 'linkUrl' => '', 'isInternal' => '0', 'cdate' => '2024-01-01', 'udate' => '2024-01-01'],
            ])),
        ]);

        $connection = $connections->create(service: 'shopify', externalId: 'ext-1', name: 'Store', logoUrl: 'https://example.com/logo.png');

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertSame('shopify', $body['connection']['service']);
        $this->assertSame('ext-1', $body['connection']['externalid']);
        $this->assertSame('Store', $body['connection']['name']);
        $this->assertSame('https://example.com/logo.png', $body['connection']['logoUrl']);
        $this->assertArrayNotHasKey('linkUrl', $body['connection']);
        $this->assertInstanceOf(Connection::class, $connection);
    }

    public function testUpdateConnection(): void
    {
        $connections = $this->makeConnections([
            new Response(200, [], (string) json_encode([
                'connection' => ['id' => '1', 'service' => 'shopify', 'externalid' => 'ext-1', 'name' => 'Updated Store', 'status' => '1', 'logoUrl' => '', 'linkUrl' => '', 'isInternal' => '0', 'cdate' => '2024-01-01', 'udate' => '2024-01-02'],
            ])),
        ]);

        $connection = $connections->update(id: 1, name: 'Updated Store');

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/connections/1', $this->history[0]['request']->getUri()->getPath());
        $this->assertSame('Updated Store', $body['connection']['name']);
        $this->assertSame('Updated Store', $connection->name);
    }

    public function testDeleteConnection(): void
    {
        $connections = $this->makeConnections([
            new Response(200, [], '{}'),
        ]);

        $connections->delete(1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/connections/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeConnections(array $responses): Connections
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Connections($client);
    }
}
