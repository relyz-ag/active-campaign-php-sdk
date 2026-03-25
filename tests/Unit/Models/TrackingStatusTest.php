<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\TrackingStatus;
use PHPUnit\Framework\TestCase;

final class TrackingStatusTest extends TestCase
{
    public function testFromArrayEnabled(): void
    {
        $status = TrackingStatus::fromArray(['enabled' => true]);

        $this->assertTrue($status->enabled);
    }

    public function testFromArrayDisabled(): void
    {
        $status = TrackingStatus::fromArray(['enabled' => false]);

        $this->assertFalse($status->enabled);
    }

    public function testFromArrayDefaultsToFalse(): void
    {
        $status = TrackingStatus::fromArray([]);

        $this->assertFalse($status->enabled);
    }
}
