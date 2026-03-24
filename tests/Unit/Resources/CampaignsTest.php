<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Campaign;
use ActiveCampaign\Sdk\Resources\Campaigns;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class CampaignsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testDuplicate(): void
    {
        $campaigns = $this->makeCampaigns([
            new Response(200, [], (string) json_encode([
                'campaign' => ['id' => '2', 'name' => 'Copy of Campaign', 'type' => 'single', 'status' => '0', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $campaigns->duplicate(1);

        $this->assertInstanceOf(Campaign::class, $result);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/campaigns/1/duplicate', $this->history[0]['request']->getUri()->getPath());
    }

    public function testGetLinks(): void
    {
        $campaigns = $this->makeCampaigns([
            new Response(200, [], (string) json_encode([
                'links' => [['id' => '1', 'url' => 'https://example.com']],
            ])),
        ]);

        $result = $campaigns->getLinks(1);

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/campaigns/1/links', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeCampaigns(array $responses): Campaigns
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Campaigns($client);
    }
}
