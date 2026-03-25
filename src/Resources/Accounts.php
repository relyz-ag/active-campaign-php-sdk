<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Account;
use ActiveCampaign\Models\Note;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Account>
 */
final class Accounts extends Resource
{
    /** @use HasCrud<Account> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'accounts';
    }
    protected function singularKey(): string
    {
        return 'account';
    }
    protected function pluralKey(): string
    {
        return 'accounts';
    }
    protected function modelClass(): string
    {
        return Account::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name, ?string $accountUrl = null): Account
    {
        return $this->createRaw($this->filterNulls([
            'name' => $name,
            'accountUrl' => $accountUrl,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null, ?string $accountUrl = null): Account
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'accountUrl' => $accountUrl,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function createNote(int $accountId, string $content): Note
    {
        return $this->createNoteRaw($accountId, ['note' => $content]);
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
    public function createNoteRaw(int $accountId, array $data): Note
    {
        $response = $this->client->post('accounts/' . $accountId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function updateNote(int $accountId, int $noteId, string $content): Note
    {
        return $this->updateNoteRaw($accountId, $noteId, ['note' => $content]);
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
    public function updateNoteRaw(int $accountId, int $noteId, array $data): Note
    {
        $response = $this->client->put('accounts/' . $accountId . '/notes/' . $noteId, ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param list<int> $ids
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function bulkDelete(array $ids): void
    {
        $this->client->delete('accounts/bulk_delete', ['ids' => $ids]);
    }
}
