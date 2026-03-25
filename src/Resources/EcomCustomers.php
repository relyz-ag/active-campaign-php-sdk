<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\EcomCustomer;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<EcomCustomer>
 */
final class EcomCustomers extends Resource
{
    /** @use HasCrud<EcomCustomer> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'ecomCustomers';
    }

    protected function singularKey(): string
    {
        return 'ecomCustomer';
    }

    protected function pluralKey(): string
    {
        return 'ecomCustomers';
    }

    protected function modelClass(): string
    {
        return EcomCustomer::class;
    }

    public function create(int $connectionId, string $externalId, string $email, ?bool $acceptsMarketing = null): EcomCustomer
    {
        return $this->create_raw(array_filter([
            'connectionid' => $connectionId,
            'externalid' => $externalId,
            'email' => $email,
            'acceptsMarketing' => $acceptsMarketing,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $externalId = null, ?string $email = null, ?bool $acceptsMarketing = null): EcomCustomer
    {
        return $this->update_raw($id, array_filter([
            'externalid' => $externalId,
            'email' => $email,
            'acceptsMarketing' => $acceptsMarketing,
        ], fn ($v) => $v !== null));
    }
}
