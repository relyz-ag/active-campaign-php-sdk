<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Webhook;
use PHPUnit\Framework\TestCase;

final class WebhookTest extends TestCase
{
    public function testFromArray(): void
    {
        $webhook = Webhook::fromArray([
            'id' => '1',
            'name' => 'Contact Updated',
            'url' => 'https://example.com/webhook',
            'listid' => '0',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $webhook->id);
        $this->assertSame('Contact Updated', $webhook->name);
        $this->assertSame('https://example.com/webhook', $webhook->url);
        $this->assertSame('0', $webhook->listid);
        $this->assertSame('2024-01-01T00:00:00-05:00', $webhook->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $webhook->updatedAt);
    }
}
