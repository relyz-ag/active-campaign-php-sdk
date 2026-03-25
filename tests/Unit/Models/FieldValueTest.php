<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\FieldValue;
use PHPUnit\Framework\TestCase;

final class FieldValueTest extends TestCase
{
    public function testFromArray(): void
    {
        $m = FieldValue::fromArray([
            'id' => '1',
            'contact' => '5',
            'field' => '10',
            'value' => 'hello',
            'cdate' => '2024-01-01',
            'udate' => '2024-01-02',
        ]);

        $this->assertSame(1, $m->id);
        $this->assertSame(5, $m->contact);
        $this->assertSame(10, $m->field);
        $this->assertSame('hello', $m->value);
        $this->assertSame('2024-01-01', $m->createdAt);
        $this->assertSame('2024-01-02', $m->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $m = FieldValue::fromArray([
            'id' => '2',
            'contact' => '3',
            'field' => '4',
        ]);

        $this->assertSame(2, $m->id);
        $this->assertSame('', $m->value);
        $this->assertSame('', $m->createdAt);
        $this->assertSame('', $m->updatedAt);
    }
}
