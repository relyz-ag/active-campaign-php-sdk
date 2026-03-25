<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\BulkImportResult;
use PHPUnit\Framework\TestCase;

final class BulkImportResultTest extends TestCase
{
    public function testFromArray(): void
    {
        $result = BulkImportResult::fromArray([
            'Success' => 1,
            'queued_contacts' => 5,
            'batchId' => 'abc-123',
            'message' => 'Import queued',
        ]);

        $this->assertTrue($result->success);
        $this->assertSame(5, $result->queuedContacts);
        $this->assertSame('abc-123', $result->batchId);
        $this->assertSame('Import queued', $result->message);
    }
}
