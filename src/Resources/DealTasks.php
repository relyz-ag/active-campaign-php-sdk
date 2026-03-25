<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\DealTask;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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
        return $this->create_raw(array_filter([
            'title' => $title,
            'dealTasktype' => $taskType,
            'relid' => $dealId,
            'status' => $status,
            'duedate' => $dueDate,
            'owner' => $ownerId,
        ], fn ($v) => $v !== null));
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
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'dealTasktype' => $taskType,
            'relid' => $dealId,
            'status' => $status,
            'duedate' => $dueDate,
            'owner' => $ownerId,
        ], fn ($v) => $v !== null));
    }
}
