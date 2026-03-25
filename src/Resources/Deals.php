<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\BulkUpdateResult;
use ActiveCampaign\Models\Deal;
use ActiveCampaign\Models\Note;
use ActiveCampaign\Resources\Concerns\HasCrud;

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
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $title,
        int $value,
        string $currency,
        int $stage,
        int $pipeline,
        ?int $owner = null,
        ?int $status = null,
    ): Deal {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'value' => $value,
            'currency' => $currency,
            'stage' => $stage,
            'group' => $pipeline,
            'owner' => $owner,
            'status' => $status,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
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
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'value' => $value,
            'currency' => $currency,
            'stage' => $stage,
            'group' => $pipeline,
            'owner' => $owner,
            'status' => $status,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function createNote(int $dealId, string $content): Note
    {
        return $this->createNoteRaw($dealId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function createNoteRaw(int $dealId, array $data): Note
    {
        $response = $this->client->post('deals/' . $dealId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function updateNote(int $dealId, int $noteId, string $content): Note
    {
        return $this->updateNoteRaw($dealId, $noteId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function updateNoteRaw(int $dealId, int $noteId, array $data): Note
    {
        $response = $this->client->put('deals/' . $dealId . '/notes/' . $noteId, ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param list<array<string, mixed>> $deals
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function bulkUpdateOwners(array $deals): BulkUpdateResult
    {
        $response = $this->client->put('deals/bulkUpdate', ['deals' => $deals]);

        return BulkUpdateResult::fromArray($response);
    }
}
