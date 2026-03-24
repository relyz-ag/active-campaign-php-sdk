<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Account;
use ActiveCampaign\Sdk\Models\Note;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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
     * @param array<string, mixed> $data
     */
    public function createNote(int $accountId, array $data): Note
    {
        $response = $this->client->post('accounts/' . $accountId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateNote(int $accountId, int $noteId, array $data): Note
    {
        $response = $this->client->put('accounts/' . $accountId . '/notes/' . $noteId, ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    /**
     * @param list<int> $ids
     */
    public function bulkDelete(array $ids): void
    {
        $this->client->delete('accounts/bulk_delete', ['ids' => $ids]);
    }
}
