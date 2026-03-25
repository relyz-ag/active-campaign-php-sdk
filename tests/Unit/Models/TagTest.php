<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Tag;
use PHPUnit\Framework\TestCase;

final class TagTest extends TestCase
{
    public function testFromArray(): void
    {
        $tag = Tag::fromArray([
            'id' => '5',
            'tag' => 'VIP Customer',
            'tagType' => 'contact',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(5, $tag->id);
        $this->assertSame('VIP Customer', $tag->name);
        $this->assertSame('contact', $tag->type);
        $this->assertSame('2024-01-01T00:00:00-05:00', $tag->createdAt);
    }
}
