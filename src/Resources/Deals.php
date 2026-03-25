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

    public function create(
        string $title,
        int $value,
        string $currency,
        int $stage,
        int $pipeline,
        ?int $owner = null,
        ?int $status = null,
    ): Deal {
        return $this->create_raw(array_filter([
            'title' => $title,
            'value' => $value,
            'currency' => $currency,
            'stage' => $stage,
            'group' => $pipeline,
            'owner' => $owner,
            'status' => $status,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?int $value = null,
        ?string $currency = null,
        ?int $stage = null,
        ?int $pipeline = null,
        ?int $owner = null,
        ?int $status = null,
    ): Deal {
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'value' => $value,
            'currency' => $currency,
            'stage' => $stage,
            'group' => $pipeline,
            'owner' => $owner,
            'status' => $status,
        ], fn ($v) => $v !== null));
    }

    public function createNote(int $dealId, string $content): Note
    {
        return $this->createNote_raw($dealId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createNote_raw(int $dealId, array $data): Note
    {
        $response = $this->client->post('deals/' . $dealId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    public function updateNote(int $dealId, int $noteId, string $content): Note
    {
        return $this->updateNote_raw($dealId, $noteId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateNote_raw(int $dealId, int $noteId, array $data): Note
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
