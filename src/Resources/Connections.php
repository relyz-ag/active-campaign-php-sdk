<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Connection;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Connection>
 */
final class Connections extends Resource
{
    /** @use HasCrud<Connection> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'connections';
    }

    protected function singularKey(): string
    {
        return 'connection';
    }

    protected function pluralKey(): string
    {
        return 'connections';
    }

    protected function modelClass(): string
    {
        return Connection::class;
    }

    public function create(string $service, string $externalId, string $name, ?string $logoUrl = null, ?string $linkUrl = null): Connection
    {
        return $this->create_raw(array_filter([
            'service' => $service,
            'externalid' => $externalId,
            'name' => $name,
            'logoUrl' => $logoUrl,
            'linkUrl' => $linkUrl,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $service = null, ?string $externalId = null, ?string $name = null, ?string $logoUrl = null, ?string $linkUrl = null): Connection
    {
        return $this->update_raw($id, array_filter([
            'service' => $service,
            'externalid' => $externalId,
            'name' => $name,
            'logoUrl' => $logoUrl,
            'linkUrl' => $linkUrl,
        ], fn ($v) => $v !== null));
    }
}
