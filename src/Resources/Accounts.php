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

    protected function endpoint(): string { return 'accounts'; }
    protected function singularKey(): string { return 'account'; }
    protected function pluralKey(): string { return 'accounts'; }
    protected function modelClass(): string { return Account::class; }
}
