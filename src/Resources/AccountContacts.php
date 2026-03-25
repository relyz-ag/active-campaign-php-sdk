<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\AccountContact;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<AccountContact>
 */
final class AccountContacts extends Resource
{
    /** @use HasCrud<AccountContact> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'accountContacts';
    }

    protected function singularKey(): string
    {
        return 'accountContact';
    }

    protected function pluralKey(): string
    {
        return 'accountContacts';
    }

    protected function modelClass(): string
    {
        return AccountContact::class;
    }

    public function create(int $account, int $contact, ?string $jobTitle = null): AccountContact
    {
        return $this->create_raw(array_filter([
            'account' => $account,
            'contact' => $contact,
            'jobTitle' => $jobTitle,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $jobTitle = null): AccountContact
    {
        return $this->update_raw($id, array_filter([
            'jobTitle' => $jobTitle,
        ], fn ($v) => $v !== null));
    }
}
