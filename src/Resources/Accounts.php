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

    public function create(string $name, ?string $accountUrl = null): Account
    {
        return $this->create_raw(array_filter([
            'name' => $name,
            'accountUrl' => $accountUrl,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $name = null, ?string $accountUrl = null): Account
    {
        return $this->update_raw($id, array_filter([
            'name' => $name,
            'accountUrl' => $accountUrl,
        ], fn ($v) => $v !== null));
    }

    public function createNote(int $accountId, string $content): Note
    {
        return $this->createNote_raw($accountId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createNote_raw(int $accountId, array $data): Note
    {
        $response = $this->client->post('accounts/' . $accountId . '/notes', ['note' => $data]);

        return Note::fromArray($response['note']);
    }

    public function updateNote(int $accountId, int $noteId, string $content): Note
    {
        return $this->updateNote_raw($accountId, $noteId, ['note' => $content]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateNote_raw(int $accountId, int $noteId, array $data): Note
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
