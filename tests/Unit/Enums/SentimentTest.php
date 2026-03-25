<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Enums;

use ActiveCampaign\Enums\Sentiment;
use PHPUnit\Framework\TestCase;

final class SentimentTest extends TestCase
{
    public function testValues(): void
    {
        $this->assertSame('POSITIVE', Sentiment::Positive->value);
        $this->assertSame('NONE', Sentiment::None->value);
    }

    public function testFromString(): void
    {
        $this->assertSame(Sentiment::Negative, Sentiment::from('NEGATIVE'));
    }
}
