<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Message;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testFromArray(): void
    {
        $message = Message::fromArray([
            'id' => '10',
            'subject' => 'Welcome',
            'fromname' => 'John',
            'fromemail' => 'john@example.com',
            'reply2' => 'reply@example.com',
            'preheader_text' => 'Preview text',
            'html' => '<p>Hello</p>',
            'text' => 'Hello',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-01-02T00:00:00-05:00',
        ]);

        $this->assertSame(10, $message->id);
        $this->assertSame('Welcome', $message->subject);
        $this->assertSame('John', $message->fromName);
        $this->assertSame('john@example.com', $message->fromEmail);
        $this->assertSame('reply@example.com', $message->reply2);
        $this->assertSame('Preview text', $message->preheaderText);
        $this->assertSame('<p>Hello</p>', $message->html);
        $this->assertSame('Hello', $message->text);
        $this->assertSame('2024-01-01T00:00:00-05:00', $message->createdAt);
        $this->assertSame('2024-01-02T00:00:00-05:00', $message->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $message = Message::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $message->id);
        $this->assertSame('', $message->subject);
        $this->assertSame('', $message->fromName);
        $this->assertSame('', $message->fromEmail);
        $this->assertSame('', $message->reply2);
        $this->assertNull($message->preheaderText);
        $this->assertNull($message->html);
        $this->assertNull($message->text);
        $this->assertSame('', $message->createdAt);
        $this->assertSame('', $message->updatedAt);
    }
}
