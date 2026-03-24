<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\BounceLog;
use PHPUnit\Framework\TestCase;

final class BounceLogTest extends TestCase
{
    public function testFromArray(): void
    {
        $log = BounceLog::fromArray([
            'id' => '1',
            'contact' => '5',
            'email' => 'a@b.com',
            'error' => 'mailbox full',
            'source' => 'smtp',
            'tstamp' => '2024-01-01',
        ]);

        $this->assertSame(1, $log->id);
        $this->assertSame(5, $log->contact);
        $this->assertSame('a@b.com', $log->email);
        $this->assertSame('mailbox full', $log->error);
        $this->assertSame('smtp', $log->source);
    }
}
