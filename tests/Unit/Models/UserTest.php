<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testFromArray(): void
    {
        $user = User::fromArray([
            'id' => '1',
            'username' => 'jdoe',
            'email' => 'jdoe@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'phone' => '555-1234',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $user->id);
        $this->assertSame('jdoe', $user->username);
        $this->assertSame('jdoe@example.com', $user->email);
        $this->assertSame('John', $user->firstName);
        $this->assertSame('Doe', $user->lastName);
        $this->assertSame('555-1234', $user->phone);
        $this->assertSame('2024-01-01T00:00:00-05:00', $user->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $user->updatedAt);
    }

    public function testFromArrayWithNullOptionalFields(): void
    {
        $user = User::fromArray([
            'id' => '1',
            'username' => 'jdoe',
            'email' => 'jdoe@example.com',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($user->firstName);
        $this->assertNull($user->lastName);
        $this->assertNull($user->phone);
    }
}
