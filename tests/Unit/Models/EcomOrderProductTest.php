<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\EcomOrderProduct;
use PHPUnit\Framework\TestCase;

final class EcomOrderProductTest extends TestCase
{
    public function testFromArray(): void
    {
        $product = EcomOrderProduct::fromArray([
            'id' => '1',
            'orderId' => '10',
            'externalid' => 'prod-123',
            'name' => 'Widget',
            'price' => '2500',
            'quantity' => '2',
            'category' => 'Gadgets',
            'sku' => 'WDG-001',
            'description' => 'A fine widget',
            'imageUrl' => 'https://example.com/widget.png',
            'productUrl' => 'https://example.com/widget',
            'createdTimestamp' => '2024-03-15T12:00:00-05:00',
            'updatedTimestamp' => '2024-03-16T08:00:00-05:00',
        ]);

        $this->assertSame(1, $product->id);
        $this->assertSame(10, $product->orderId);
        $this->assertSame('prod-123', $product->externalId);
        $this->assertSame('Widget', $product->name);
        $this->assertSame(2500, $product->price);
        $this->assertSame(2, $product->quantity);
        $this->assertSame('Gadgets', $product->category);
        $this->assertSame('WDG-001', $product->sku);
        $this->assertSame('A fine widget', $product->description);
        $this->assertSame('https://example.com/widget.png', $product->imageUrl);
        $this->assertSame('https://example.com/widget', $product->productUrl);
        $this->assertSame('2024-03-15T12:00:00-05:00', $product->createdAt);
        $this->assertSame('2024-03-16T08:00:00-05:00', $product->updatedAt);
    }

    public function testFromArrayWithOrderidFallback(): void
    {
        $product = EcomOrderProduct::fromArray([
            'id' => '2',
            'orderid' => '15',
        ]);

        $this->assertSame(15, $product->orderId);
    }

    public function testFromArrayWithDefaults(): void
    {
        $product = EcomOrderProduct::fromArray([
            'id' => '5',
        ]);

        $this->assertSame(5, $product->id);
        $this->assertSame(0, $product->orderId);
        $this->assertSame('', $product->externalId);
        $this->assertSame('', $product->name);
        $this->assertSame(0, $product->price);
        $this->assertSame(0, $product->quantity);
        $this->assertNull($product->category);
        $this->assertNull($product->sku);
        $this->assertNull($product->description);
        $this->assertNull($product->imageUrl);
        $this->assertNull($product->productUrl);
        $this->assertSame('', $product->createdAt);
        $this->assertSame('', $product->updatedAt);
    }
}
