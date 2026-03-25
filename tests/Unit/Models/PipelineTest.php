<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Pipeline;
use PHPUnit\Framework\TestCase;

final class PipelineTest extends TestCase
{
    public function testFromArray(): void
    {
        $pipeline = Pipeline::fromArray([
            'id' => '1',
            'title' => 'Sales Pipeline',
            'currency' => 'usd',
            'autoassign' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $pipeline->id);
        $this->assertSame('Sales Pipeline', $pipeline->title);
        $this->assertSame('usd', $pipeline->currency);
        $this->assertTrue($pipeline->autoassign);
        $this->assertSame('2024-01-01T00:00:00-05:00', $pipeline->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $pipeline->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $pipeline = Pipeline::fromArray([
            'id' => '2',
            'title' => 'Support Pipeline',
            'currency' => 'eur',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertFalse($pipeline->autoassign);
    }
}
