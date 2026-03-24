<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Deal;
use PHPUnit\Framework\TestCase;

final class DealTest extends TestCase
{
    public function testFromArray(): void
    {
        $deal = Deal::fromArray([
            'id' => '1',
            'title' => 'Big Sale',
            'value' => '10000',
            'currency' => 'usd',
            'stage' => '2',
            'pipeline' => '1',
            'owner' => '1',
            'status' => '0',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $deal->id);
        $this->assertSame('Big Sale', $deal->title);
        $this->assertSame(10000, $deal->value);
        $this->assertSame('usd', $deal->currency);
        $this->assertSame(2, $deal->stage);
        $this->assertSame(1, $deal->pipeline);
        $this->assertSame(1, $deal->owner);
        $this->assertSame(0, $deal->status);
        $this->assertSame('2024-01-01T00:00:00-05:00', $deal->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $deal->updatedAt);
    }

    public function testFromArrayWithNullOwner(): void
    {
        $deal = Deal::fromArray([
            'id' => '1',
            'title' => 'Big Sale',
            'value' => '10000',
            'currency' => 'usd',
            'stage' => '2',
            'pipeline' => '1',
            'status' => '0',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($deal->owner);
    }
}
