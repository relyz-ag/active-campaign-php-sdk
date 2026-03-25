<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\SiteTrackingDomain;
use ActiveCampaign\Models\TrackingStatus;
use ActiveCampaign\Resources\SiteTracking;
use GuzzleHttp\Psr7\Response;

final class SiteTrackingTest extends ResourceTestCase
{
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
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertTrue($result->enabled);
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
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertTrue($result->enabled);
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
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertFalse($result->enabled);
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
        $this->assertInstanceOf(SiteTrackingDomain::class, $result);
        $this->assertSame('example.com', $result->name);
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
        $this->assertCount(2, $result);
        $this->assertInstanceOf(SiteTrackingDomain::class, $result[0]);
        $this->assertSame('example.com', $result[0]->name);
        $this->assertSame('test.com', $result[1]->name);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): SiteTracking
    {
        return new SiteTracking($this->makeClient($responses));
    }
}
