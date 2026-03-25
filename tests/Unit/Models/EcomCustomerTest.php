<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\EcomCustomer;
use PHPUnit\Framework\TestCase;

final class EcomCustomerTest extends TestCase
{
    public function testFromArray(): void
    {
        $customer = EcomCustomer::fromArray([
            'id' => '1',
            'connectionid' => '2',
            'externalid' => 'cust-456',
            'email' => 'jane@example.com',
            'totalRevenue' => '15000',
            'totalOrders' => '3',
            'totalProducts' => '7',
            'acceptsMarketing' => '1',
            'tstamp' => '2024-01-15T10:30:00-05:00',
        ]);

        $this->assertSame(1, $customer->id);
        $this->assertSame(2, $customer->connectionId);
        $this->assertSame('cust-456', $customer->externalId);
        $this->assertSame('jane@example.com', $customer->email);
        $this->assertSame(15000, $customer->totalRevenue);
        $this->assertSame(3, $customer->totalOrders);
        $this->assertSame(7, $customer->totalProducts);
        $this->assertTrue($customer->acceptsMarketing);
        $this->assertSame('2024-01-15T10:30:00-05:00', $customer->createdAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $customer = EcomCustomer::fromArray([
            'id' => '5',
        ]);

        $this->assertSame(5, $customer->id);
        $this->assertSame(0, $customer->connectionId);
        $this->assertSame('', $customer->externalId);
        $this->assertSame('', $customer->email);
        $this->assertSame(0, $customer->totalRevenue);
        $this->assertSame(0, $customer->totalOrders);
        $this->assertSame(0, $customer->totalProducts);
        $this->assertFalse($customer->acceptsMarketing);
        $this->assertSame('', $customer->createdAt);
    }
}
