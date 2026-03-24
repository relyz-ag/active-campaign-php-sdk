<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\ScoreValue;
use PHPUnit\Framework\TestCase;

final class ScoreValueTest extends TestCase
{
    public function testFromArray(): void
    {
        $sv = ScoreValue::fromArray([
            'id' => '1',
            'score' => '2',
            'contact' => '1',
            'deal' => null,
            'scoreValue' => '85',
            'cdate' => '2024-01-01',
            'mdate' => '2024-01-02',
        ]);

        $this->assertSame(1, $sv->id);
        $this->assertSame(2, $sv->score);
        $this->assertSame(85, $sv->scoreValue);
        $this->assertNull($sv->deal);
    }

    public function testFromArrayWithDeal(): void
    {
        $sv = ScoreValue::fromArray([
            'id' => '1',
            'score' => '2',
            'contact' => '1',
            'deal' => '5',
            'scoreValue' => '50',
            'cdate' => '2024-01-01',
            'mdate' => '2024-01-02',
        ]);

        $this->assertSame(5, $sv->deal);
    }
}
