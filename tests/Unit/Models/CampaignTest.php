<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Enums\CampaignStatus;
use ActiveCampaign\Models\Campaign;
use PHPUnit\Framework\TestCase;

final class CampaignTest extends TestCase
{
    public function testFromArray(): void
    {
        $campaign = Campaign::fromArray([
            'id' => '1',
            'name' => 'Summer Sale',
            'type' => 'single',
            'status' => '5',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $campaign->id);
        $this->assertSame('Summer Sale', $campaign->name);
        $this->assertSame('single', $campaign->type);
        $this->assertSame(CampaignStatus::Sent, $campaign->status);
        $this->assertSame('2024-01-01T00:00:00-05:00', $campaign->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $campaign->updatedAt);
    }
}
