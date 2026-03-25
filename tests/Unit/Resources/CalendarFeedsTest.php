<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\CalendarFeed;
use ActiveCampaign\Resources\CalendarFeeds;
use GuzzleHttp\Psr7\Response;

final class CalendarFeedsTest extends ResourceTestCase
{
    public function testCreate(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'calendar' => [
                    'id' => '1',
                    'userid' => '1',
                    'title' => 'Deal Calendar',
                    'type' => 'deals',
                    'token' => 'abc123',
                    'notification' => '1',
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(title: 'Deal Calendar', type: 'deals', notification: true);

        $this->assertInstanceOf(CalendarFeed::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Deal Calendar', $result->title);
        $this->assertSame('deals', $result->type);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/calendars', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertTrue($body['calendar']['notification']);
    }

    public function testUpdate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'calendar' => [
                    'id' => '1',
                    'userid' => '1',
                    'title' => 'Updated Calendar',
                    'type' => 'deals',
                    'token' => 'abc123',
                    'notification' => '0',
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-02',
                ],
            ])),
        ]);

        $result = $resource->update(id: 1, title: 'Updated Calendar');

        $this->assertInstanceOf(CalendarFeed::class, $result);
        $this->assertSame('Updated Calendar', $result->title);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/calendars/1', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Updated Calendar', $body['calendar']['title']);
        $this->assertArrayNotHasKey('type', $body['calendar']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): CalendarFeeds
    {
        return new CalendarFeeds($this->makeClient($responses));
    }
}
