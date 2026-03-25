<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealTaskOutcome;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $title,
        string $sentiment,
    ): DealTaskOutcome {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'sentiment' => $sentiment,
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
        ?string $sentiment = null,
    ): DealTaskOutcome {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'sentiment' => $sentiment,
        ]));
    }
}
