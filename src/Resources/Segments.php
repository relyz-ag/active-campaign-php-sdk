<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Segment;
use ActiveCampaign\Resources\Concerns\HasCrud;

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
        return $this->createRaw(array_filter([
            'name' => $name,
            'seriesid' => $seriesId,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $name = null, ?int $seriesId = null): Segment
    {
        return $this->updateRaw($id, array_filter([
            'name' => $name,
            'seriesid' => $seriesId,
        ], fn ($v) => $v !== null));
    }
}
