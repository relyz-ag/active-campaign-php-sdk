<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Resources\SiteTracking;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SiteTrackingTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testGetStatus(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'siteTracking' => ['enabled' => true],
            ])),
        ]);

        $result = $resource->getStatus();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/siteTracking', $this->history[0]['request']->getUri()->getPath());
        $this->assertTrue($result['siteTracking']['enabled']);
    }

    public function testEnable(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'siteTracking' => ['enabled' => true],
            ])),
        ]);

        $result = $resource->enable();

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['siteTracking' => ['enabled' => true]], $body);
        $this->assertTrue($result['siteTracking']['enabled']);
    }

    public function testDisable(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'siteTracking' => ['enabled' => false],
            ])),
        ]);

        $result = $resource->disable();

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['siteTracking' => ['enabled' => false]], $body);
        $this->assertFalse($result['siteTracking']['enabled']);
    }

    public function testAddWhitelistDomain(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'siteTrackingDomain' => ['name' => 'example.com'],
            ])),
        ]);

        $result = $resource->addWhitelistDomain('example.com');

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['siteTrackingDomain' => ['name' => 'example.com']], $body);
        $this->assertSame('example.com', $result['siteTrackingDomain']['name']);
    }

    public function testRemoveWhitelistDomain(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->removeWhitelistDomain('example.com');

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/siteTrackingDomains/example.com', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListWhitelistDomains(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'siteTrackingDomains' => [
                    ['name' => 'example.com'],
                    ['name' => 'test.com'],
                ],
            ])),
        ]);

        $result = $resource->listWhitelistDomains();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/siteTrackingDomains', $this->history[0]['request']->getUri()->getPath());
        $this->assertCount(2, $result['siteTrackingDomains']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): SiteTracking
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new SiteTracking($client);
    }
}
