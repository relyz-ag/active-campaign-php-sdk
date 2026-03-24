<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\Webhooks;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class WebhooksTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListEvents(): void
    {
        $webhooks = $this->makeWebhooks([
            new Response(200, [], (string) json_encode([
                'webhookEvents' => ['subscribe', 'unsubscribe', 'deal_add'],
            ])),
        ]);

        $result = $webhooks->listEvents();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/webhooks/events', $this->history[0]['request']->getUri()->getPath());
        $this->assertSame(['subscribe', 'unsubscribe', 'deal_add'], $result);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeWebhooks(array $responses): Webhooks
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Webhooks($client);
    }
}
