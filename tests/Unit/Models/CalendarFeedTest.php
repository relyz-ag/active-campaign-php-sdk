<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\CalendarFeed;
use PHPUnit\Framework\TestCase;

final class CalendarFeedTest extends TestCase
{
    public function testFromArray(): void
    {
        $feed = CalendarFeed::fromArray([
            'id' => '4',
            'userid' => '1',
            'title' => 'My Calendar',
            'type' => 'deals',
            'token' => 'abc123',
            'notification' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(4, $feed->id);
        $this->assertSame(1, $feed->userId);
        $this->assertSame('My Calendar', $feed->title);
        $this->assertSame('deals', $feed->type);
        $this->assertSame('abc123', $feed->token);
        $this->assertTrue($feed->notification);
        $this->assertSame('2024-01-01T00:00:00-05:00', $feed->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $feed->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $feed = CalendarFeed::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $feed->id);
        $this->assertSame(0, $feed->userId);
        $this->assertNull($feed->title);
        $this->assertNull($feed->type);
        $this->assertNull($feed->token);
        $this->assertFalse($feed->notification);
        $this->assertNull($feed->createdAt);
        $this->assertNull($feed->updatedAt);
    }
}
