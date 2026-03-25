<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\TrackingLog;
use PHPUnit\Framework\TestCase;

final class TrackingLogTest extends TestCase
{
    public function testFromArray(): void
    {
        $log = TrackingLog::fromArray([
            'subscriberid' => '42',
            'type' => 'page_visit',
            'value' => 'https://example.com/pricing',
            'tstamp' => '2024-06-15T10:30:00-05:00',
        ]);

        $this->assertSame(42, $log->subscriberId);
        $this->assertSame('page_visit', $log->type);
        $this->assertSame('https://example.com/pricing', $log->value);
        $this->assertSame('2024-06-15T10:30:00-05:00', $log->timestamp);
    }
}
