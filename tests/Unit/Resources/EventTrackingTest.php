<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\TrackingEvent;
use ActiveCampaign\Models\TrackingStatus;
use ActiveCampaign\Resources\EventTracking;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class EventTrackingTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testGetStatus(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'eventTracking' => ['enabled' => true],
            ])),
        ]);

        $result = $resource->getStatus();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/eventTracking', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertTrue($result->enabled);
    }

    public function testEnable(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'eventTracking' => ['enabled' => true],
            ])),
        ]);

        $result = $resource->enable();

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['eventTracking' => ['enabled' => true]], $body);
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertTrue($result->enabled);
    }

    public function testDisable(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'eventTracking' => ['enabled' => false],
            ])),
        ]);

        $result = $resource->disable();

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['eventTracking' => ['enabled' => false]], $body);
        $this->assertInstanceOf(TrackingStatus::class, $result);
        $this->assertFalse($result->enabled);
    }

    public function testListEvents(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'eventTrackingEvents' => [
                    ['name' => 'my_event'],
                    ['name' => 'another_event'],
                ],
            ])),
        ]);

        $result = $resource->listEvents();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/eventTrackingEvents', $this->history[0]['request']->getUri()->getPath());
        $this->assertCount(2, $result);
        $this->assertInstanceOf(TrackingEvent::class, $result[0]);
        $this->assertSame('my_event', $result[0]->name);
        $this->assertSame('another_event', $result[1]->name);
    }

    public function testCreateEvent(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'eventTrackingEvent' => ['name' => 'my_event'],
            ])),
        ]);

        $result = $resource->createEvent('my_event');

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['eventTrackingEvent' => ['name' => 'my_event']], $body);
        $this->assertInstanceOf(TrackingEvent::class, $result);
        $this->assertSame('my_event', $result->name);
    }

    public function testDeleteEvent(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->deleteEvent('my_event');

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/eventTrackingEvents/my_event', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): EventTracking
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new EventTracking($client);
    }
}
