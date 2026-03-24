<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Address;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Address>
 */
final class Addresses extends Resource
{
    /** @use HasCrud<Address> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'addresses';
    }
    protected function singularKey(): string
    {
        return 'address';
    }
    protected function pluralKey(): string
    {
        return 'addresses';
    }
    protected function modelClass(): string
    {
        return Address::class;
    }

    public function deleteByGroup(int $groupId): void
    {
        $this->client->delete('addresses/group/' . $groupId);
    }

    public function deleteByList(int $listId): void
    {
        $this->client->delete('addresses/list/' . $listId);
    }
}
