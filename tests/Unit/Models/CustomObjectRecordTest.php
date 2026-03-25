<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\CustomObjectRecord;
use PHPUnit\Framework\TestCase;

final class CustomObjectRecordTest extends TestCase
{
    public function testFromArray(): void
    {
        $record = CustomObjectRecord::fromArray([
            'id' => 'rec-uuid-001',
            'externalId' => 'ext-123',
            'schemaId' => 'schema-uuid-456',
            'fields' => ['name' => 'Test', 'value' => 42],
            'relationships' => ['contact' => ['id' => '1']],
        ]);

        $this->assertSame('rec-uuid-001', $record->id);
        $this->assertSame('ext-123', $record->externalId);
        $this->assertSame('schema-uuid-456', $record->schemaId);
        $this->assertSame(['name' => 'Test', 'value' => 42], $record->fields);
        $this->assertSame(['contact' => ['id' => '1']], $record->relationships);
    }

    public function testFromArrayWithDefaults(): void
    {
        $record = CustomObjectRecord::fromArray([]);

        $this->assertSame('', $record->id);
        $this->assertNull($record->externalId);
        $this->assertSame('', $record->schemaId);
        $this->assertSame([], $record->fields);
        $this->assertSame([], $record->relationships);
    }
}
