<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\AccountCustomField;
use PHPUnit\Framework\TestCase;

final class AccountCustomFieldTest extends TestCase
{
    public function testFromArray(): void
    {
        $m = AccountCustomField::fromArray([
            'id' => '1',
            'fieldLabel' => 'Company Size',
            'fieldType' => 'text',
            'fieldDefault' => 'Small',
            'isFormVisible' => '1',
            'displayOrder' => '3',
            'createdTimestamp' => '2024-01-01',
            'updatedTimestamp' => '2024-01-02',
        ]);

        $this->assertSame(1, $m->id);
        $this->assertSame('Company Size', $m->fieldLabel);
        $this->assertSame('text', $m->fieldType);
        $this->assertSame('Small', $m->fieldDefault);
        $this->assertTrue($m->isFormVisible);
        $this->assertSame(3, $m->displayOrder);
        $this->assertSame('2024-01-01', $m->createdAt);
        $this->assertSame('2024-01-02', $m->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $m = AccountCustomField::fromArray([
            'id' => '2',
            'fieldLabel' => 'Industry',
            'fieldType' => 'dropdown',
        ]);

        $this->assertSame(2, $m->id);
        $this->assertNull($m->fieldDefault);
        $this->assertFalse($m->isFormVisible);
        $this->assertSame(0, $m->displayOrder);
        $this->assertSame('', $m->createdAt);
        $this->assertSame('', $m->updatedAt);
    }
}
