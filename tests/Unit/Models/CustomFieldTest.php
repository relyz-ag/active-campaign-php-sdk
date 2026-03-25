<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\CustomField;
use PHPUnit\Framework\TestCase;

final class CustomFieldTest extends TestCase
{
    public function testFromArray(): void
    {
        $field = CustomField::fromArray([
            'id' => '3',
            'fieldLabel' => 'Company Size',
            'fieldType' => 'dropdown',
            'fieldDefault' => 'Small',
            'isFormVisible' => '1',
            'isRequired' => '0',
            'displayOrder' => '2',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(3, $field->id);
        $this->assertSame('Company Size', $field->label);
        $this->assertSame('dropdown', $field->type);
        $this->assertSame('Small', $field->default);
        $this->assertTrue($field->isFormVisible);
        $this->assertFalse($field->isRequired);
        $this->assertSame(2, $field->displayOrder);
        $this->assertSame('2024-01-01T00:00:00-05:00', $field->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $field->updatedAt);
    }

    public function testFromArrayWithNullDefault(): void
    {
        $field = CustomField::fromArray([
            'id' => '1',
            'fieldLabel' => 'Notes',
            'fieldType' => 'text',
            'isFormVisible' => '1',
            'isRequired' => '1',
            'displayOrder' => '1',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($field->default);
        $this->assertTrue($field->isRequired);
    }
}
