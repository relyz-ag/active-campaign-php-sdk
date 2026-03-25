<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\DealCustomField;
use PHPUnit\Framework\TestCase;

final class DealCustomFieldTest extends TestCase
{
    public function testFromArray(): void
    {
        $field = DealCustomField::fromArray([
            'id' => '1',
            'fieldLabel' => 'Revenue',
            'fieldType' => 'currency',
            'fieldDefault' => '0',
            'isFormVisible' => '1',
            'isRequired' => '1',
            'displayOrder' => '3',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $field->id);
        $this->assertSame('Revenue', $field->fieldLabel);
        $this->assertSame('currency', $field->fieldType);
        $this->assertSame('0', $field->fieldDefault);
        $this->assertTrue($field->isFormVisible);
        $this->assertTrue($field->isRequired);
        $this->assertSame(3, $field->displayOrder);
        $this->assertSame('2024-01-01T00:00:00-05:00', $field->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $field->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $field = DealCustomField::fromArray([
            'id' => '2',
            'fieldLabel' => 'Notes',
            'fieldType' => 'text',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($field->fieldDefault);
        $this->assertFalse($field->isFormVisible);
        $this->assertFalse($field->isRequired);
        $this->assertSame(0, $field->displayOrder);
    }
}
