<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\DealTaskType;
use PHPUnit\Framework\TestCase;

final class DealTaskTypeTest extends TestCase
{
    public function testFromArray(): void
    {
        $type = DealTaskType::fromArray([
            'id' => '1',
            'title' => 'Follow Up',
            'status' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $type->id);
        $this->assertSame('Follow Up', $type->title);
        $this->assertSame(1, $type->status);
        $this->assertSame('2024-01-01T00:00:00-05:00', $type->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $type->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $type = DealTaskType::fromArray([
            'id' => '2',
            'title' => 'Call',
        ]);

        $this->assertSame(0, $type->status);
        $this->assertSame('', $type->createdAt);
        $this->assertSame('', $type->updatedAt);
    }
}
