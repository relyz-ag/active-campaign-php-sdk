<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Account;
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
     * @return array<string, mixed>
     */
    public function createNote(int $accountId, array $data): array
    {
        return $this->client->post('accounts/' . $accountId . '/notes', ['note' => $data]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function updateNote(int $accountId, int $noteId, array $data): array
    {
        return $this->client->put('accounts/' . $accountId . '/notes/' . $noteId, ['note' => $data]);
    }

    /**
     * @param list<int> $ids
     */
    public function bulkDelete(array $ids): void
    {
        $this->client->delete('accounts/bulk_delete', ['ids' => $ids]);
    }
}
