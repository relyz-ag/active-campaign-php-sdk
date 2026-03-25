<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testFromArray(): void
    {
        $address = Address::fromArray([
            'id' => '1',
            'companyName' => 'Acme Corp',
            'address1' => '123 Main St',
            'address2' => 'Suite 100',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60601',
            'country' => 'US',
            'phone' => '555-9876',
            'isDefault' => '1',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $address->id);
        $this->assertSame('Acme Corp', $address->companyName);
        $this->assertSame('123 Main St', $address->address1);
        $this->assertSame('Suite 100', $address->address2);
        $this->assertSame('Chicago', $address->city);
        $this->assertSame('IL', $address->state);
        $this->assertSame('60601', $address->zip);
        $this->assertSame('US', $address->country);
        $this->assertSame('555-9876', $address->phone);
        $this->assertTrue($address->isDefault);
        $this->assertSame('2024-01-01T00:00:00-05:00', $address->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $address->updatedAt);
    }

    public function testFromArrayWithNullOptionalFields(): void
    {
        $address = Address::fromArray([
            'id' => '2',
            'isDefault' => '0',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($address->companyName);
        $this->assertNull($address->address1);
        $this->assertNull($address->address2);
        $this->assertNull($address->city);
        $this->assertNull($address->state);
        $this->assertNull($address->zip);
        $this->assertNull($address->country);
        $this->assertNull($address->phone);
        $this->assertFalse($address->isDefault);
    }
}
