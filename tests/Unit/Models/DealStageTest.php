<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\DealStage;
use PHPUnit\Framework\TestCase;

final class DealStageTest extends TestCase
{
    public function testFromArray(): void
    {
        $stage = DealStage::fromArray([
            'id' => '1',
            'title' => 'To Contact',
            'group' => '1',
            'order' => '1',
            'color' => '32B0FC',
            'width' => '280',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $stage->id);
        $this->assertSame('To Contact', $stage->title);
        $this->assertSame(1, $stage->pipeline);
        $this->assertSame(1, $stage->order);
        $this->assertSame('32B0FC', $stage->color);
        $this->assertSame(280, $stage->width);
        $this->assertSame('2024-01-01T00:00:00-05:00', $stage->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $stage->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $stage = DealStage::fromArray([
            'id' => '2',
            'title' => 'In Progress',
            'group' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(0, $stage->order);
        $this->assertNull($stage->color);
        $this->assertSame(280, $stage->width);
    }
}
