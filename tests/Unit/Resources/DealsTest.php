<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\Deals;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DealsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateNote(): void
    {
        $deals = $this->makeDeals([
            new Response(201, [], (string) json_encode([
                'note' => ['id' => '1', 'note' => 'Test note'],
            ])),
        ]);

        $result = $deals->createNote(dealId: 1, data: ['note' => 'Test note']);

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/1/notes', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    public function testUpdateNote(): void
    {
        $deals = $this->makeDeals([
            new Response(200, [], (string) json_encode([
                'note' => ['id' => '1', 'note' => 'Updated note'],
            ])),
        ]);

        $result = $deals->updateNote(dealId: 1, noteId: 2, data: ['note' => 'Updated note']);

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/1/notes/2', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    public function testBulkUpdateOwners(): void
    {
        $deals = $this->makeDeals([
            new Response(200, [], (string) json_encode([
                'deals' => [],
            ])),
        ]);

        $result = $deals->bulkUpdateOwners([['id' => 1, 'owner' => 2]]);

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/bulkUpdate', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDeals(array $responses): Deals
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Deals($client);
    }
}
