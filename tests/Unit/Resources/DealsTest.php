<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\BulkUpdateResult;
use ActiveCampaign\Sdk\Models\Note;
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
                'note' => ['id' => '1', 'note' => 'Test note', 'relid' => '1', 'reltype' => 'Deal', 'userid' => '1', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $deals->createNote(dealId: 1, data: ['note' => 'Test note']);

        $this->assertInstanceOf(Note::class, $result);
        $this->assertSame('Test note', $result->content);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/1/notes', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateNote(): void
    {
        $deals = $this->makeDeals([
            new Response(200, [], (string) json_encode([
                'note' => ['id' => '1', 'note' => 'Updated note', 'relid' => '1', 'reltype' => 'Deal', 'userid' => '1', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $deals->updateNote(dealId: 1, noteId: 2, data: ['note' => 'Updated note']);

        $this->assertInstanceOf(Note::class, $result);
        $this->assertSame('Updated note', $result->content);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/1/notes/2', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkUpdateOwners(): void
    {
        $deals = $this->makeDeals([
            new Response(200, [], (string) json_encode([
                'success' => ['1', '2'],
                'nochange' => ['3'],
                'failed' => [],
            ])),
        ]);

        $result = $deals->bulkUpdateOwners([['id' => 1, 'owner' => 2]]);

        $this->assertInstanceOf(BulkUpdateResult::class, $result);
        $this->assertCount(2, $result->success);
        $this->assertCount(1, $result->nochange);
        $this->assertEmpty($result->failed);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/deals/bulkUpdate', $this->history[0]['request']->getUri()->getPath());
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
