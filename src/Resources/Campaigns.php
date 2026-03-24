<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Campaign;
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
     * @return array<string, mixed>
     */
    public function getLinks(int $id): array
    {
        return $this->client->get('campaigns/' . $id . '/links');
    }
}
