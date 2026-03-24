<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Deal;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Deal>
 */
final class Deals extends Resource
{
    /** @use HasCrud<Deal> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'deals';
    }
    protected function singularKey(): string
    {
        return 'deal';
    }
    protected function pluralKey(): string
    {
        return 'deals';
    }
    protected function modelClass(): string
    {
        return Deal::class;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function createNote(int $dealId, array $data): array
    {
        return $this->client->post('deals/' . $dealId . '/notes', ['note' => $data]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function updateNote(int $dealId, int $noteId, array $data): array
    {
        return $this->client->put('deals/' . $dealId . '/notes/' . $noteId, ['note' => $data]);
    }

    /**
     * @param list<array<string, mixed>> $deals
     * @return array<string, mixed>
     */
    public function bulkUpdateOwners(array $deals): array
    {
        return $this->client->put('deals/bulkUpdate', ['deals' => $deals]);
    }
}
