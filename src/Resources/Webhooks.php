<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Webhook;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Webhook>
 */
final class Webhooks extends Resource
{
    /** @use HasCrud<Webhook> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'webhooks';
    }
    protected function singularKey(): string
    {
        return 'webhook';
    }
    protected function pluralKey(): string
    {
        return 'webhooks';
    }
    protected function modelClass(): string
    {
        return Webhook::class;
    }

    public function create(string $name, string $url, string $listid): Webhook
    {
        return $this->createRaw([
            'name' => $name,
            'url' => $url,
            'listid' => $listid,
        ]);
    }

    public function update(int $id, ?string $name = null, ?string $url = null, ?string $listid = null): Webhook
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'url' => $url,
            'listid' => $listid,
        ]));
    }

    /**
     * @return list<string>
     */
    public function listEvents(): array
    {
        $response = $this->client->get('webhooks/events');

        return $response['webhookEvents'] ?? [];
    }
}
