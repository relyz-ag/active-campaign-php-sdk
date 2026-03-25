<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Resources\Settings;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SettingsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testUpdateSettings(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'settings' => [
                    'timezone' => 'America/New_York',
                    'trackLinks' => true,
                ],
            ])),
        ]);

        $result = $resource->update([
            'timezone' => 'America/New_York',
            'trackLinks' => true,
        ]);

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/settings', $this->history[0]['request']->getUri()->getPath());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('America/New_York', $body['timezone']);
        $this->assertTrue($body['trackLinks']);
        $this->assertSame('America/New_York', $result['settings']['timezone']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Settings
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Settings($client);
    }
}
