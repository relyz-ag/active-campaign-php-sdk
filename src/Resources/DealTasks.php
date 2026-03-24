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
}
