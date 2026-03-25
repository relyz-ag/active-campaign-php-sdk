<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Campaign;
use ActiveCampaign\Models\CampaignLink;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Campaign>
 */
final class Campaigns extends Resource
{
    /** @use HasCrud<Campaign> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'campaigns';
    }
    protected function singularKey(): string
    {
        return 'campaign';
    }
    protected function pluralKey(): string
    {
        return 'campaigns';
    }
    protected function modelClass(): string
    {
        return Campaign::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name, string $type): Campaign
    {
        return $this->createRaw([
            'name' => $name,
            'type' => $type,
        ]);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null, ?string $type = null): Campaign
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'type' => $type,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function duplicate(int $id): Campaign
    {
        $response = $this->client->post('campaigns/' . $id . '/duplicate');

        return Campaign::fromArray($response['campaign']);
    }

    /**
     * @return list<CampaignLink>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function getLinks(int $id): array
    {
        $response = $this->client->get('campaigns/' . $id . '/links');

        return array_map(
            fn (array $item) => CampaignLink::fromArray($item),
            $response['links'] ?? [],
        );
    }
}
