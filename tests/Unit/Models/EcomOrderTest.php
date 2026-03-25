<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\EcomOrder;
use PHPUnit\Framework\TestCase;

final class EcomOrderTest extends TestCase
{
    public function testFromArray(): void
    {
        $order = EcomOrder::fromArray([
            'id' => '1',
            'connectionid' => '2',
            'customerid' => '3',
            'externalid' => 'order-789',
            'email' => 'jane@example.com',
            'totalPrice' => '9999',
            'currency' => 'USD',
            'orderNumber' => 'ORD-001',
            'orderDate' => '2024-03-15T12:00:00-05:00',
            'shippingMethod' => 'UPS Ground',
            'state' => '1',
            'createdDate' => '2024-03-15T12:00:00-05:00',
            'updatedDate' => '2024-03-16T08:00:00-05:00',
        ]);

        $this->assertSame(1, $order->id);
        $this->assertSame(2, $order->connectionId);
        $this->assertSame(3, $order->customerId);
        $this->assertSame('order-789', $order->externalId);
        $this->assertSame('jane@example.com', $order->email);
        $this->assertSame(9999, $order->totalPrice);
        $this->assertSame('USD', $order->currency);
        $this->assertSame('ORD-001', $order->orderNumber);
        $this->assertSame('2024-03-15T12:00:00-05:00', $order->orderDate);
        $this->assertSame('UPS Ground', $order->shippingMethod);
        $this->assertSame(1, $order->state);
        $this->assertSame('2024-03-15T12:00:00-05:00', $order->createdAt);
        $this->assertSame('2024-03-16T08:00:00-05:00', $order->updatedAt);
    }

    public function testFromArrayWithFallbackFields(): void
    {
        $order = EcomOrder::fromArray([
            'id' => '2',
            'externalCreatedDate' => '2024-01-01T00:00:00-05:00',
            'tstamp' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(2, $order->id);
        $this->assertSame('2024-01-01T00:00:00-05:00', $order->orderDate);
        $this->assertSame('2024-01-02T00:00:00-05:00', $order->createdAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $order = EcomOrder::fromArray([
            'id' => '5',
        ]);

        $this->assertSame(5, $order->id);
        $this->assertSame(0, $order->connectionId);
        $this->assertSame(0, $order->customerId);
        $this->assertNull($order->externalId);
        $this->assertNull($order->email);
        $this->assertSame(0, $order->totalPrice);
        $this->assertNull($order->currency);
        $this->assertNull($order->orderNumber);
        $this->assertNull($order->orderDate);
        $this->assertNull($order->shippingMethod);
        $this->assertSame(0, $order->state);
        $this->assertNull($order->createdAt);
        $this->assertNull($order->updatedAt);
    }
}
