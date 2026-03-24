<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\BulkUpdateResult;
use PHPUnit\Framework\TestCase;

final class BulkUpdateResultTest extends TestCase
{
    public function testFromArray(): void
    {
        $result = BulkUpdateResult::fromArray([
            'success' => ['1', '2'],
            'nochange' => ['3'],
            'failed' => [],
        ]);

        $this->assertSame(['1', '2'], $result->success);
        $this->assertSame(['3'], $result->nochange);
        $this->assertEmpty($result->failed);
    }
}
