<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\SavedResponse;
use PHPUnit\Framework\TestCase;

final class SavedResponseTest extends TestCase
{
    public function testFromArray(): void
    {
        $savedResponse = SavedResponse::fromArray([
            'id' => '8',
            'title' => 'Follow Up',
            'subject' => 'Re: Your inquiry',
            'body' => 'Thank you for reaching out.',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(8, $savedResponse->id);
        $this->assertSame('Follow Up', $savedResponse->title);
        $this->assertSame('Re: Your inquiry', $savedResponse->subject);
        $this->assertSame('Thank you for reaching out.', $savedResponse->body);
        $this->assertSame('2024-01-01T00:00:00-05:00', $savedResponse->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $savedResponse->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $savedResponse = SavedResponse::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $savedResponse->id);
        $this->assertNull($savedResponse->title);
        $this->assertNull($savedResponse->subject);
        $this->assertNull($savedResponse->body);
        $this->assertNull($savedResponse->createdAt);
        $this->assertNull($savedResponse->updatedAt);
    }
}
