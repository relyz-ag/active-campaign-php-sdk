<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\ContactDeal;
use PHPUnit\Framework\TestCase;

final class ContactDealTest extends TestCase
{
    public function testFromArray(): void
    {
        $cd = ContactDeal::fromArray([
            'id' => '1',
            'deal' => '5',
            'contact' => '10',
            'role' => '0',
            'cdate' => '2024-01-01',
        ]);

        $this->assertSame(1, $cd->id);
        $this->assertSame(5, $cd->deal);
        $this->assertSame(10, $cd->contact);
        $this->assertSame(0, $cd->role);
    }
}
