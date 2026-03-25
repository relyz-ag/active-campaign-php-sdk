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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $title,
        string $currency,
        ?bool $autoassign = null,
    ): Pipeline {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'currency' => $currency,
            'autoassign' => $autoassign,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(
        int $id,
        ?string $title = null,
        ?string $currency = null,
        ?bool $autoassign = null,
    ): Pipeline {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'currency' => $currency,
            'autoassign' => $autoassign,
        ]));
    }
}
