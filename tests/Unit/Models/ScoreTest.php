<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Score;
use PHPUnit\Framework\TestCase;

final class ScoreTest extends TestCase
{
    public function testFromArray(): void
    {
        $score = Score::fromArray([
            'id' => '3',
            'name' => 'Lead Score',
            'reltype' => 'contact',
            'descript' => 'Scores contacts based on engagement',
            'status' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(3, $score->id);
        $this->assertSame('Lead Score', $score->name);
        $this->assertSame('contact', $score->relType);
        $this->assertSame('Scores contacts based on engagement', $score->description);
        $this->assertSame(1, $score->status);
        $this->assertSame('2024-01-01T00:00:00-05:00', $score->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $score->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $score = Score::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $score->id);
        $this->assertSame('', $score->name);
        $this->assertSame('', $score->relType);
        $this->assertSame('', $score->description);
        $this->assertSame(0, $score->status);
        $this->assertSame('', $score->createdAt);
        $this->assertSame('', $score->updatedAt);
    }
}
