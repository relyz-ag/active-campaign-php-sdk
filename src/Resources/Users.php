<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\User;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    public function create(string $username, string $email, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): User
    {
        return $this->createRaw($this->filterNulls([
            'username' => $username,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

    public function update(int $id, ?string $username = null, ?string $email = null, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): User
    {
        return $this->updateRaw($id, $this->filterNulls([
            'username' => $username,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

    public function getByEmail(string $email): User
    {
        $response = $this->client->get('users/email/' . urlencode($email));

        return User::fromArray($response['user']);
    }

    public function getByUsername(string $username): User
    {
        $response = $this->client->get('users/username/' . urlencode($username));

        return User::fromArray($response['user']);
    }

    public function me(): User
    {
        $response = $this->client->get('users/me');

        return User::fromArray($response['user']);
    }
}
