<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Campaign;
use ActiveCampaign\Sdk\Models\CampaignLink;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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

    public function duplicate(int $id): Campaign
    {
        $response = $this->client->post('campaigns/' . $id . '/duplicate');

        return Campaign::fromArray($response['campaign']);
    }

    /**
     * @return list<CampaignLink>
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
