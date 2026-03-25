<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\BulkImportStatus;
use PHPUnit\Framework\TestCase;

final class BulkImportStatusTest extends TestCase
{
    public function testFromArray(): void
    {
        $status = BulkImportStatus::fromArray([
            'status' => 'completed',
            'success' => ['123', '124'],
            'failure' => ['bad@invalid'],
        ]);

        $this->assertSame('completed', $status->status);
        $this->assertSame(['123', '124'], $status->successIds);
        $this->assertSame(['bad@invalid'], $status->failedEmails);
    }
}
