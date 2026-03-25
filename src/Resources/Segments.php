<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Segment;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Segment>
 */
final class Segments extends Resource
{
    /** @use HasCrud<Segment> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'segments';
    }
    protected function singularKey(): string
    {
        return 'segment';
    }
    protected function pluralKey(): string
    {
        return 'segments';
    }
    protected function modelClass(): string
    {
        return Segment::class;
    }

    public function create(string $name, ?int $seriesId = null): Segment
    {
        return $this->create_raw(array_filter([
            'name' => $name,
            'seriesid' => $seriesId,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $name = null, ?int $seriesId = null): Segment
    {
        return $this->update_raw($id, array_filter([
            'name' => $name,
            'seriesid' => $seriesId,
        ], fn ($v) => $v !== null));
    }
}
