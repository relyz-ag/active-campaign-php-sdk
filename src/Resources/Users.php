<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\User;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<User>
 */
final class Users extends Resource
{
    /** @use HasCrud<User> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'users';
    }
    protected function singularKey(): string
    {
        return 'user';
    }
    protected function pluralKey(): string
    {
        return 'users';
    }
    protected function modelClass(): string
    {
        return User::class;
    }
}
