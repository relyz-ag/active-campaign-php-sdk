<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\DealRole;
use PHPUnit\Framework\TestCase;

final class DealRoleTest extends TestCase
{
    public function testFromArray(): void
    {
        $role = DealRole::fromArray([
            'id' => '1',
            'title' => 'Decision Maker',
            'created_timestamp' => '2024-01-01T00:00:00-05:00',
            'updated_timestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $role->id);
        $this->assertSame('Decision Maker', $role->title);
        $this->assertSame('2024-01-01T00:00:00-05:00', $role->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $role->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $role = DealRole::fromArray([
            'id' => '2',
            'title' => 'Influencer',
        ]);

        $this->assertSame('', $role->createdAt);
        $this->assertSame('', $role->updatedAt);
    }
}
