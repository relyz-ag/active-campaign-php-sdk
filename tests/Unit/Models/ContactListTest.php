<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\ContactList;
use PHPUnit\Framework\TestCase;

final class ContactListTest extends TestCase
{
    public function testFromArray(): void
    {
        $cl = ContactList::fromArray([
            'id' => '1',
            'contact' => '5',
            'list' => '3',
            'status' => '1',
            'sdate' => '2024-01-01',
            'udate' => '2024-01-02',
        ]);

        $this->assertSame(1, $cl->id);
        $this->assertSame(5, $cl->contact);
        $this->assertSame(3, $cl->list);
        $this->assertSame(1, $cl->status);
        $this->assertSame('2024-01-01', $cl->subscribedAt);
        $this->assertSame('2024-01-02', $cl->updatedAt);
    }
}
