<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\Branding;
use ActiveCampaign\Resources\Brandings;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class BrandingsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testUpdate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'branding' => [
                    'id' => '1',
                    'groupid' => '3',
                    'siteName' => 'Updated Site',
                    'siteLogo' => 'https://example.com/logo.png',
                    'siteLogoSmall' => 'https://example.com/logo-small.png',
                    'headerTextValue' => 'New Header',
                    'footerTextValue' => 'New Footer',
                ],
            ])),
        ]);

        $result = $resource->update(id: 1, siteName: 'Updated Site', headerTextValue: 'New Header');

        $this->assertInstanceOf(Branding::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Updated Site', $result->siteName);
        $this->assertSame('New Header', $result->headerTextValue);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/brandings/1', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Updated Site', $body['branding']['siteName']);
        $this->assertSame('New Header', $body['branding']['headerTextValue']);
        $this->assertArrayNotHasKey('siteLogo', $body['branding']);
    }

    public function testGet(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'branding' => [
                    'id' => '1',
                    'groupid' => '3',
                    'siteName' => 'My Site',
                    'siteLogo' => 'https://example.com/logo.png',
                    'siteLogoSmall' => 'https://example.com/logo-small.png',
                    'headerTextValue' => 'Header',
                    'footerTextValue' => 'Footer',
                ],
            ])),
        ]);

        $result = $resource->get(1);

        $this->assertInstanceOf(Branding::class, $result);
        $this->assertSame('My Site', $result->siteName);
        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/brandings/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Brandings
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Brandings($client);
    }
}
