<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\DealTaskOutcome;
use PHPUnit\Framework\TestCase;

final class DealTaskOutcomeTest extends TestCase
{
    public function testFromArray(): void
    {
        $outcome = DealTaskOutcome::fromArray([
            'id' => '1',
            'title' => 'Completed',
            'sentiment' => 'POSITIVE',
            'disabled' => '0',
            'created_by' => '1',
        ]);

        $this->assertSame(1, $outcome->id);
        $this->assertSame('Completed', $outcome->title);
        $this->assertSame('POSITIVE', $outcome->sentiment);
        $this->assertSame('0', $outcome->disabled);
        $this->assertSame(1, $outcome->createdBy);
    }

    public function testFromArrayWithDefaults(): void
    {
        $outcome = DealTaskOutcome::fromArray([
            'id' => '2',
            'title' => 'No Answer',
        ]);

        $this->assertNull($outcome->sentiment);
        $this->assertNull($outcome->disabled);
        $this->assertNull($outcome->createdBy);
    }
}
