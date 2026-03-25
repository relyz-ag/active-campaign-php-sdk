<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\DealRole;
use ActiveCampaign\Sdk\Resources\DealRoles;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DealRolesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateReturnsDealRoleModel(): void
    {
        $roles = $this->makeDealRoles([
            new Response(201, [], (string) json_encode([
                'dealRole' => [
                    'id' => '1',
                    'title' => 'Decision Maker',
                    'created_timestamp' => '2024-01-01T00:00:00-05:00',
                    'updated_timestamp' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $roles->create(title: 'Decision Maker');

        $this->assertInstanceOf(DealRole::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Decision Maker', $result->title);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealRoles', $this->history[0]['request']->getUri()->getPath());
    }

    public function testDelete(): void
    {
        $roles = $this->makeDealRoles([
            new Response(200, [], (string) json_encode([])),
        ]);

        $roles->delete(id: 1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealRoles/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealRoles(array $responses): DealRoles
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new DealRoles($client);
    }
}
