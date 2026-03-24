<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Segment;
use PHPUnit\Framework\TestCase;

final class SegmentTest extends TestCase
{
    public function testFromArray(): void
    {
        $segment = Segment::fromArray([
            'id' => '12',
            'name' => 'Active Subscribers',
            'seriesid' => '3',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(12, $segment->id);
        $this->assertSame('Active Subscribers', $segment->name);
        $this->assertSame(3, $segment->seriesId);
        $this->assertSame('2024-01-01T00:00:00-05:00', $segment->createdAt);
    }

    public function testFromArrayWithNullSeriesId(): void
    {
        $segment = Segment::fromArray([
            'id' => '12',
            'name' => 'Active Subscribers',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertNull($segment->seriesId);
    }
}
