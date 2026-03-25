<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Pipeline;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Pipeline>
 */
final class Pipelines extends Resource
{
    /** @use HasCrud<Pipeline> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealGroups';
    }
    protected function singularKey(): string
    {
        return 'dealGroup';
    }
    protected function pluralKey(): string
    {
        return 'dealGroups';
    }
    protected function modelClass(): string
    {
        return Pipeline::class;
    }

    public function create(
        string $title,
        string $currency,
        ?bool $autoassign = null,
    ): Pipeline {
        return $this->create_raw(array_filter([
            'title' => $title,
            'currency' => $currency,
            'autoassign' => $autoassign,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?string $currency = null,
        ?bool $autoassign = null,
    ): Pipeline {
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'currency' => $currency,
            'autoassign' => $autoassign,
        ], fn ($v) => $v !== null));
    }
}
