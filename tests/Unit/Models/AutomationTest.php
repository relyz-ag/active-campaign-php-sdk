<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Automation;
use PHPUnit\Framework\TestCase;

final class AutomationTest extends TestCase
{
    public function testFromArray(): void
    {
        $automation = Automation::fromArray([
            'id' => '1',
            'name' => 'Welcome Series',
            'status' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $automation->id);
        $this->assertSame('Welcome Series', $automation->name);
        $this->assertSame('1', $automation->status);
        $this->assertSame('2024-01-01T00:00:00-05:00', $automation->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $automation->updatedAt);
    }
}
