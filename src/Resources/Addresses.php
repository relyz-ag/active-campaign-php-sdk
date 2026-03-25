<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Address;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    public function create(
        ?string $companyName = null,
        ?string $address1 = null,
        ?string $address2 = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zip = null,
        ?string $country = null,
        ?string $phone = null,
        ?bool $isDefault = null,
    ): Address {
        return $this->createRaw($this->filterNulls([
            'companyName' => $companyName,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
            'phone' => $phone,
            'isDefault' => $isDefault,
        ]));
    }

    public function update(
        int $id,
        ?string $companyName = null,
        ?string $address1 = null,
        ?string $address2 = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zip = null,
        ?string $country = null,
        ?string $phone = null,
        ?bool $isDefault = null,
    ): Address {
        return $this->updateRaw($id, $this->filterNulls([
            'companyName' => $companyName,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $country,
            'phone' => $phone,
            'isDefault' => $isDefault,
        ]));
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
