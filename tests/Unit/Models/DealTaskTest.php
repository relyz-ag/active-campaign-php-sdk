<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\DealTask;
use PHPUnit\Framework\TestCase;

final class DealTaskTest extends TestCase
{
    public function testFromArray(): void
    {
        $task = DealTask::fromArray([
            'id' => '10',
            'title' => 'Send proposal',
            'relid' => '5',
            'status' => '0',
            'duedate' => '2024-07-01T12:00:00-05:00',
            'owner' => '2',
            'tasktype' => 'call',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(10, $task->id);
        $this->assertSame('Send proposal', $task->title);
        $this->assertSame(5, $task->dealId);
        $this->assertSame(0, $task->status);
        $this->assertSame('2024-07-01T12:00:00-05:00', $task->dueDate);
        $this->assertSame(2, $task->ownerId);
        $this->assertSame('call', $task->taskType);
        $this->assertSame('2024-01-01T00:00:00-05:00', $task->createdAt);
    }

    public function testFromArrayWithNullOptionalFields(): void
    {
        $task = DealTask::fromArray([
            'id' => '10',
            'title' => 'Send proposal',
            'relid' => '5',
            'status' => '1',
            'cdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertNull($task->dueDate);
        $this->assertNull($task->ownerId);
        $this->assertNull($task->taskType);
    }
}
