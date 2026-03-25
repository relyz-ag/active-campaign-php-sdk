<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\EmailActivity;
use PHPUnit\Framework\TestCase;

final class EmailActivityTest extends TestCase
{
    public function testFromArray(): void
    {
        $activity = EmailActivity::fromArray([
            'tstamp' => '2024-06-15T10:30:00-05:00',
            'type' => 'open',
            'subscriberid' => '42',
            'campaignid' => '7',
        ]);

        $this->assertSame('2024-06-15T10:30:00-05:00', $activity->timestamp);
        $this->assertSame('open', $activity->type);
        $this->assertSame(42, $activity->subscriberId);
        $this->assertSame(7, $activity->campaignId);
    }
}
