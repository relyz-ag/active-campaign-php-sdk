<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Note;
use ActiveCampaign\Sdk\Resources\Accounts;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AccountsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateNote(): void
    {
        $accounts = $this->makeAccounts([
            new Response(201, [], (string) json_encode([
                'note' => ['id' => '1', 'note' => 'Account note', 'relid' => '1', 'reltype' => 'CustomerAccount', 'userid' => '1', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $accounts->createNote(accountId: 1, data: ['note' => 'Account note']);

        $this->assertInstanceOf(Note::class, $result);
        $this->assertSame('Account note', $result->content);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accounts/1/notes', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateNote(): void
    {
        $accounts = $this->makeAccounts([
            new Response(200, [], (string) json_encode([
                'note' => ['id' => '1', 'note' => 'Updated', 'relid' => '1', 'reltype' => 'CustomerAccount', 'userid' => '1', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $accounts->updateNote(accountId: 1, noteId: 2, data: ['note' => 'Updated']);

        $this->assertInstanceOf(Note::class, $result);
        $this->assertSame('Updated', $result->content);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accounts/1/notes/2', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkDelete(): void
    {
        $accounts = $this->makeAccounts([
            new Response(200, [], '{}'),
        ]);

        $accounts->bulkDelete([1, 2, 3]);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accounts/bulk_delete', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeAccounts(array $responses): Accounts
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Accounts($client);
    }
}
