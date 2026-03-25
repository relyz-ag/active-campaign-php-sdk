<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\DealTaskOutcome;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealTaskOutcome>
 */
final class DealTaskOutcomes extends Resource
{
    /** @use HasCrud<DealTaskOutcome> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'taskOutcomes';
    }
    protected function singularKey(): string
    {
        return 'taskOutcome';
    }
    protected function pluralKey(): string
    {
        return 'taskOutcomes';
    }
    protected function modelClass(): string
    {
        return DealTaskOutcome::class;
    }

    public function create(
        string $title,
        string $sentiment,
    ): DealTaskOutcome {
        return $this->create_raw(array_filter([
            'title' => $title,
            'sentiment' => $sentiment,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?string $sentiment = null,
    ): DealTaskOutcome {
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'sentiment' => $sentiment,
        ], fn ($v) => $v !== null));
    }
}
