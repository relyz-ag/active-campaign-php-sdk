<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealTaskType;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealTaskType>
 */
final class DealTaskTypes extends Resource
{
    /** @use HasCrud<DealTaskType> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealTasktypes';
    }
    protected function singularKey(): string
    {
        return 'dealTasktype';
    }
    protected function pluralKey(): string
    {
        return 'dealTasktypes';
    }
    protected function modelClass(): string
    {
        return DealTaskType::class;
    }

    public function create(
        string $title,
    ): DealTaskType {
        return $this->createRaw(array_filter([
            'title' => $title,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?int $status = null,
    ): DealTaskType {
        return $this->updateRaw($id, array_filter([
            'title' => $title,
            'status' => $status,
        ], fn ($v) => $v !== null));
    }
}
