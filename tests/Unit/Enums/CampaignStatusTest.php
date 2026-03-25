<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Enums;

use ActiveCampaign\Enums\CampaignStatus;
use PHPUnit\Framework\TestCase;

final class CampaignStatusTest extends TestCase
{
    public function testValues(): void
    {
        $this->assertSame(0, CampaignStatus::Draft->value);
        $this->assertSame(5, CampaignStatus::Sent->value);
    }

    public function testFromInt(): void
    {
        $this->assertSame(CampaignStatus::Sending, CampaignStatus::from(3));
    }

    public function testTryFromUnknown(): void
    {
        $this->assertNull(CampaignStatus::tryFrom(99));
    }
}
