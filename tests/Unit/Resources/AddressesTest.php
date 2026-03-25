<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Resources\Addresses;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AddressesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testDeleteByGroup(): void
    {
        $addresses = $this->makeAddresses([
            new Response(200, [], '{}'),
        ]);

        $addresses->deleteByGroup(groupId: 5);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/addresses/group/5', $this->history[0]['request']->getUri()->getPath());
    }

    public function testDeleteByList(): void
    {
        $addresses = $this->makeAddresses([
            new Response(200, [], '{}'),
        ]);

        $addresses->deleteByList(listId: 3);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/addresses/list/3', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeAddresses(array $responses): Addresses
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Addresses($client);
    }
}
