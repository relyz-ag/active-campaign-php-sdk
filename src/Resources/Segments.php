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
}
