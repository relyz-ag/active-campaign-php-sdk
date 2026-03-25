<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\AccountContact;
use PHPUnit\Framework\TestCase;

final class AccountContactTest extends TestCase
{
    public function testFromArray(): void
    {
        $m = AccountContact::fromArray([
            'id' => '1',
            'account' => '5',
            'contact' => '10',
            'jobTitle' => 'Engineer',
            'createdTimestamp' => '2024-01-01',
            'updatedTimestamp' => '2024-01-02',
        ]);

        $this->assertSame(1, $m->id);
        $this->assertSame(5, $m->account);
        $this->assertSame(10, $m->contact);
        $this->assertSame('Engineer', $m->jobTitle);
        $this->assertSame('2024-01-01', $m->createdAt);
        $this->assertSame('2024-01-02', $m->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $m = AccountContact::fromArray([
            'id' => '2',
            'account' => '3',
            'contact' => '4',
        ]);

        $this->assertSame(2, $m->id);
        $this->assertNull($m->jobTitle);
        $this->assertNull($m->createdAt);
        $this->assertNull($m->updatedAt);
    }
}
