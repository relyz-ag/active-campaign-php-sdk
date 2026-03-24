<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\BulkUpdateResult;
use ActiveCampaign\Sdk\Models\Deal;
use ActiveCampaign\Sdk\Models\Note;
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
     */
    public function createNote(int $dealId, array $data): Note
    {
        $response = $this->client->post('deals/' . $dealId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateNote(int $dealId, int $noteId, array $data): Note
    {
        $response = $this->client->put('deals/' . $dealId . '/notes/' . $noteId, ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param list<array<string, mixed>> $deals
     */
    public function bulkUpdateOwners(array $deals): BulkUpdateResult
    {
        $response = $this->client->put('deals/bulkUpdate', ['deals' => $deals]);

        return BulkUpdateResult::fromArray($response);
    }
}
