<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Group;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Group>
 */
final class Groups extends Resource
{
    /** @use HasCrud<Group> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'groups';
    }

    protected function singularKey(): string
    {
        return 'group';
    }

    protected function pluralKey(): string
    {
        return 'groups';
    }

    protected function modelClass(): string
    {
        return Group::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $title, ?string $description = null): Group
    {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'descript' => $description,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $title = null, ?string $description = null): Group
    {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'descript' => $description,
        ]));
    }

    /**
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listLimits(): array
    {
        return $this->client->get('groups/limits');
    }
}
