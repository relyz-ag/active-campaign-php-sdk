<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\MailingList;
use PHPUnit\Framework\TestCase;

final class MailingListTest extends TestCase
{
    public function testFromArray(): void
    {
        $list = MailingList::fromArray([
            'id' => '1',
            'name' => 'Newsletter',
            'stringid' => 'newsletter',
            'sender_url' => 'https://example.com',
            'sender_reminder' => 'You signed up on our website.',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'udate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $list->id);
        $this->assertSame('Newsletter', $list->name);
        $this->assertSame('newsletter', $list->stringid);
        $this->assertSame('https://example.com', $list->senderUrl);
        $this->assertSame('You signed up on our website.', $list->senderReminder);
        $this->assertSame('2024-01-01T00:00:00-05:00', $list->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $list->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $list = MailingList::fromArray([
            'id' => '1',
            'name' => 'Newsletter',
            'stringid' => 'newsletter',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertNull($list->senderUrl);
        $this->assertNull($list->senderReminder);
        $this->assertSame('2024-01-01T00:00:00-05:00', $list->updatedAt);
    }
}
