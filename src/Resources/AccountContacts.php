<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\AccountContact;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(int $account, int $contact, ?string $jobTitle = null): AccountContact
    {
        return $this->createRaw($this->filterNulls([
            'account' => $account,
            'contact' => $contact,
            'jobTitle' => $jobTitle,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $jobTitle = null): AccountContact
    {
        return $this->updateRaw($id, $this->filterNulls([
            'jobTitle' => $jobTitle,
        ]));
    }
}
