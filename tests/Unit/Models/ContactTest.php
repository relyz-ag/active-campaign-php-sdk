<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Contact;
use PHPUnit\Framework\TestCase;

final class ContactTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = json_decode(
            (string) file_get_contents(__DIR__ . '/../../Fixtures/contact.json'),
            true,
        );

        $contact = Contact::fromArray($data['contact']);

        $this->assertSame(1, $contact->id);
        $this->assertSame('jane@example.com', $contact->email);
        $this->assertSame('Jane', $contact->firstName);
        $this->assertSame('Doe', $contact->lastName);
        $this->assertSame('+1234567890', $contact->phone);
        $this->assertSame('2024-01-15T10:30:00-05:00', $contact->createdAt);
        $this->assertSame('2024-06-20T14:00:00-05:00', $contact->updatedAt);
    }

    public function testFromArrayWithNullableFields(): void
    {
        $contact = Contact::fromArray([
            'id' => '5',
            'email' => 'test@example.com',
            'firstName' => null,
            'lastName' => null,
            'phone' => null,
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertNull($contact->firstName);
        $this->assertNull($contact->lastName);
        $this->assertNull($contact->phone);
    }
}
