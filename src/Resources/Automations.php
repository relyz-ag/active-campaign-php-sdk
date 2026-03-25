<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Automation;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Automation>
 */
final class Automations extends Resource
{
    /** @use HasCrud<Automation> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'automations';
    }
    protected function singularKey(): string
    {
        return 'automation';
    }
    protected function pluralKey(): string
    {
        return 'automations';
    }
    protected function modelClass(): string
    {
        return Automation::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name): Automation
    {
        return $this->createRaw(['name' => $name]);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null): Automation
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
        ]));
    }
}
