<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Webhook;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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

    /**
     * @return list<string>
     */
    public function listEvents(): array
    {
        $response = $this->client->get('webhooks/events');

        return $response['webhookEvents'] ?? [];
    }
}
