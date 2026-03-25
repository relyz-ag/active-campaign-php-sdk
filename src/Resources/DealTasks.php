<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealTask;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealTask>
 */
final class DealTasks extends Resource
{
    /** @use HasCrud<DealTask> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealTasks';
    }
    protected function singularKey(): string
    {
        return 'dealTask';
    }
    protected function pluralKey(): string
    {
        return 'dealTasks';
    }
    protected function modelClass(): string
    {
        return DealTask::class;
    }

    public function create(
        string $title,
        int $dealId,
        ?int $status = null,
        ?string $dueDate = null,
        ?int $ownerId = null,
        ?string $taskType = null,
    ): DealTask {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'dealTasktype' => $taskType,
            'relid' => $dealId,
            'status' => $status,
            'duedate' => $dueDate,
            'owner' => $ownerId,
        ]));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?int $dealId = null,
        ?int $status = null,
        ?string $dueDate = null,
        ?int $ownerId = null,
        ?string $taskType = null,
    ): DealTask {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'dealTasktype' => $taskType,
            'relid' => $dealId,
            'status' => $status,
            'duedate' => $dueDate,
            'owner' => $ownerId,
        ]));
    }
}
