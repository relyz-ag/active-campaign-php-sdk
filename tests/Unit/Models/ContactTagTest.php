<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\ContactTag;
use PHPUnit\Framework\TestCase;

final class ContactTagTest extends TestCase
{
    public function testFromArray(): void
    {
        $tag = ContactTag::fromArray([
            'id' => '10',
            'contact' => '1',
            'tag' => '5',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(10, $tag->id);
        $this->assertSame(1, $tag->contact);
        $this->assertSame(5, $tag->tag);
        $this->assertSame('2024-01-01T00:00:00-05:00', $tag->createdAt);
    }
}
