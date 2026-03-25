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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name, ?int $seriesId = null): Segment
    {
        return $this->createRaw($this->filterNulls([
            'name' => $name,
            'seriesid' => $seriesId,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null, ?int $seriesId = null): Segment
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'seriesid' => $seriesId,
        ]));
    }
}
