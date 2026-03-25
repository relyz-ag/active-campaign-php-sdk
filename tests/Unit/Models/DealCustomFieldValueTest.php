<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\DealCustomFieldValue;
use PHPUnit\Framework\TestCase;

final class DealCustomFieldValueTest extends TestCase
{
    public function testFromArray(): void
    {
        $value = DealCustomFieldValue::fromArray([
            'id' => '1',
            'dealId' => '5',
            'customFieldId' => '3',
            'fieldValue' => '1000',
            'fieldCurrency' => 'usd',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $value->id);
        $this->assertSame(5, $value->dealId);
        $this->assertSame(3, $value->customFieldId);
        $this->assertSame('1000', $value->fieldValue);
        $this->assertSame('usd', $value->fieldCurrency);
        $this->assertSame('2024-01-01T00:00:00-05:00', $value->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $value->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $value = DealCustomFieldValue::fromArray([
            'id' => '2',
            'dealId' => '5',
            'customFieldId' => '3',
        ]);

        $this->assertSame('', $value->fieldValue);
        $this->assertNull($value->fieldCurrency);
        $this->assertSame('', $value->createdAt);
        $this->assertSame('', $value->updatedAt);
    }
}
