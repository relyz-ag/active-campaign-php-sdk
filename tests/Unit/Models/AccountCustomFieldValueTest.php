<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\AccountCustomFieldValue;
use PHPUnit\Framework\TestCase;

final class AccountCustomFieldValueTest extends TestCase
{
    public function testFromArray(): void
    {
        $m = AccountCustomFieldValue::fromArray([
            'id' => '1',
            'accountId' => '5',
            'customFieldId' => '10',
            'fieldValue' => 'hello',
            'createdTimestamp' => '2024-01-01',
            'updatedTimestamp' => '2024-01-02',
        ]);

        $this->assertSame(1, $m->id);
        $this->assertSame(5, $m->accountId);
        $this->assertSame(10, $m->customFieldId);
        $this->assertSame('hello', $m->fieldValue);
        $this->assertSame('2024-01-01', $m->createdAt);
        $this->assertSame('2024-01-02', $m->updatedAt);
    }

    public function testFromArrayWithMetumId(): void
    {
        $m = AccountCustomFieldValue::fromArray([
            'id' => '2',
            'accountId' => '3',
            'accountCustomFieldMetumId' => '7',
            'fieldValue' => 'world',
        ]);

        $this->assertSame(2, $m->id);
        $this->assertSame(3, $m->accountId);
        $this->assertSame(7, $m->customFieldId);
        $this->assertSame('world', $m->fieldValue);
    }

    public function testFromArrayWithDefaults(): void
    {
        $m = AccountCustomFieldValue::fromArray([
            'id' => '3',
        ]);

        $this->assertSame(3, $m->id);
        $this->assertSame(0, $m->accountId);
        $this->assertSame(0, $m->customFieldId);
        $this->assertNull($m->fieldValue);
        $this->assertNull($m->createdAt);
        $this->assertNull($m->updatedAt);
    }
}
