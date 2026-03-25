<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Account;
use PHPUnit\Framework\TestCase;

final class AccountTest extends TestCase
{
    public function testFromArray(): void
    {
        $account = Account::fromArray([
            'id' => '1',
            'name' => 'Acme Corp',
            'accountUrl' => 'https://acme.com',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $account->id);
        $this->assertSame('Acme Corp', $account->name);
        $this->assertSame('https://acme.com', $account->accountUrl);
        $this->assertSame('2024-01-01T00:00:00-05:00', $account->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $account->updatedAt);
    }

    public function testFromArrayWithNullUrl(): void
    {
        $account = Account::fromArray([
            'id' => '1',
            'name' => 'Acme Corp',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($account->accountUrl);
    }
}
