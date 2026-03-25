<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\TrackingEvent;
use PHPUnit\Framework\TestCase;

final class TrackingEventTest extends TestCase
{
    public function testFromArray(): void
    {
        $event = TrackingEvent::fromArray(['name' => 'my_event']);

        $this->assertSame('my_event', $event->name);
    }
}
