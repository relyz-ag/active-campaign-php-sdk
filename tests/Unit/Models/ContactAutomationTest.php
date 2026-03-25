<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\ContactAutomation;
use PHPUnit\Framework\TestCase;

final class ContactAutomationTest extends TestCase
{
    public function testFromArray(): void
    {
        $ca = ContactAutomation::fromArray([
            'id' => '3',
            'contact' => '64',
            'automation' => '2',
            'status' => '1',
            'completed' => 0,
            'completeValue' => 50,
            'adddate' => '2024-01-01T00:00:00-05:00',
            'remdate' => null,
        ]);

        $this->assertSame(3, $ca->id);
        $this->assertSame(64, $ca->contact);
        $this->assertSame(2, $ca->automation);
        $this->assertSame(1, $ca->status);
        $this->assertSame(0, $ca->completed);
        $this->assertSame(50, $ca->completeValue);
        $this->assertNull($ca->removeDate);
    }
}
