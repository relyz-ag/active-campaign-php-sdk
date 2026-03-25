<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\FieldOption;
use PHPUnit\Framework\TestCase;

final class FieldOptionTest extends TestCase
{
    public function testFromArray(): void
    {
        $fieldOption = FieldOption::fromArray([
            'id' => '7',
            'field' => '3',
            'value' => 'Option A',
            'label' => 'Option A Label',
            'isdefault' => '1',
            'orderid' => '2',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(7, $fieldOption->id);
        $this->assertSame(3, $fieldOption->field);
        $this->assertSame('Option A', $fieldOption->value);
        $this->assertSame('Option A Label', $fieldOption->label);
        $this->assertTrue($fieldOption->isDefault);
        $this->assertSame(2, $fieldOption->orderid);
        $this->assertSame('2024-01-01T00:00:00-05:00', $fieldOption->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $fieldOption->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $fieldOption = FieldOption::fromArray([
            'id' => '1',
            'field' => '2',
        ]);

        $this->assertSame(1, $fieldOption->id);
        $this->assertSame(2, $fieldOption->field);
        $this->assertNull($fieldOption->value);
        $this->assertNull($fieldOption->label);
        $this->assertFalse($fieldOption->isDefault);
        $this->assertSame(0, $fieldOption->orderid);
        $this->assertNull($fieldOption->createdAt);
        $this->assertNull($fieldOption->updatedAt);
    }
}
