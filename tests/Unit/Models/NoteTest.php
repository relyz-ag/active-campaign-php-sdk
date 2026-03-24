<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Note;
use PHPUnit\Framework\TestCase;

final class NoteTest extends TestCase
{
    public function testFromArray(): void
    {
        $note = Note::fromArray([
            'id' => '7',
            'note' => 'Follow up next week',
            'relid' => '42',
            'reltype' => 'Deal',
            'userid' => '3',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(7, $note->id);
        $this->assertSame('Follow up next week', $note->content);
        $this->assertSame(42, $note->relatedId);
        $this->assertSame('Deal', $note->relatedType);
        $this->assertSame(3, $note->userId);
        $this->assertSame('2024-01-01T00:00:00-05:00', $note->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $note->updatedAt);
    }

    public function testFromArrayWithNullUserId(): void
    {
        $note = Note::fromArray([
            'id' => '7',
            'note' => 'System generated note',
            'relid' => '42',
            'reltype' => 'Contact',
            'cdate' => '2024-01-01T00:00:00-05:00',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertNull($note->userId);
    }
}
