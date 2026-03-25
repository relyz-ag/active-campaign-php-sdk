<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Connection;
use PHPUnit\Framework\TestCase;

final class ConnectionTest extends TestCase
{
    public function testFromArray(): void
    {
        $connection = Connection::fromArray([
            'id' => '1',
            'service' => 'shopify',
            'externalid' => 'ext-123',
            'name' => 'My Shopify Store',
            'status' => '1',
            'logoUrl' => 'https://example.com/logo.png',
            'linkUrl' => 'https://example.com',
            'isInternal' => '0',
            'cdate' => '2024-01-15T10:30:00-05:00',
            'udate' => '2024-06-20T14:00:00-05:00',
        ]);

        $this->assertSame(1, $connection->id);
        $this->assertSame('shopify', $connection->service);
        $this->assertSame('ext-123', $connection->externalId);
        $this->assertSame('My Shopify Store', $connection->name);
        $this->assertSame(1, $connection->status);
        $this->assertSame('https://example.com/logo.png', $connection->logoUrl);
        $this->assertSame('https://example.com', $connection->linkUrl);
        $this->assertFalse($connection->isInternal);
        $this->assertSame('2024-01-15T10:30:00-05:00', $connection->createdAt);
        $this->assertSame('2024-06-20T14:00:00-05:00', $connection->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $connection = Connection::fromArray([
            'id' => '5',
        ]);

        $this->assertSame(5, $connection->id);
        $this->assertSame('', $connection->service);
        $this->assertSame('', $connection->externalId);
        $this->assertSame('', $connection->name);
        $this->assertSame(0, $connection->status);
        $this->assertSame('', $connection->logoUrl);
        $this->assertSame('', $connection->linkUrl);
        $this->assertFalse($connection->isInternal);
        $this->assertSame('', $connection->createdAt);
        $this->assertSame('', $connection->updatedAt);
    }
}
