<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\AccountContact;
use ActiveCampaign\Sdk\Resources\AccountContacts;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AccountContactsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'accountContact' => ['id' => '1', 'account' => '5', 'contact' => '10', 'jobTitle' => 'Engineer', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(account: 5, contact: 10, jobTitle: 'Engineer');

        $this->assertInstanceOf(AccountContact::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->account);
        $this->assertSame(10, $result->contact);
        $this->assertSame('Engineer', $result->jobTitle);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountContacts', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'accountContact' => ['id' => '1', 'account' => '5', 'contact' => '10', 'jobTitle' => 'Manager', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, jobTitle: 'Manager');

        $this->assertInstanceOf(AccountContact::class, $result);
        $this->assertSame('Manager', $result->jobTitle);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountContacts/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): AccountContacts
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new AccountContacts($client);
    }
}
