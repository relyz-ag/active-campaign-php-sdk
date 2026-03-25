<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Group;
use PHPUnit\Framework\TestCase;

final class GroupTest extends TestCase
{
    public function testFromArray(): void
    {
        $group = Group::fromArray([
            'id' => '5',
            'title' => 'Admin Group',
            'descript' => 'Administrators',
            'p_admin' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(5, $group->id);
        $this->assertSame('Admin Group', $group->title);
        $this->assertSame('Administrators', $group->description);
        $this->assertTrue($group->isAdmin);
        $this->assertSame('2024-01-01T00:00:00-05:00', $group->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $group->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $group = Group::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $group->id);
        $this->assertSame('', $group->title);
        $this->assertSame('', $group->description);
        $this->assertFalse($group->isAdmin);
        $this->assertSame('', $group->createdAt);
        $this->assertSame('', $group->updatedAt);
    }
}
