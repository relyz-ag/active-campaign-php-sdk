<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealRole;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealRole>
 */
final class DealRoles extends Resource
{
    /** @use HasCrud<DealRole> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealRoles';
    }
    protected function singularKey(): string
    {
        return 'dealRole';
    }
    protected function pluralKey(): string
    {
        return 'dealRoles';
    }
    protected function modelClass(): string
    {
        return DealRole::class;
    }

    public function create(
        string $title,
    ): DealRole {
        return $this->create_raw(array_filter([
            'title' => $title,
        ], fn ($v) => $v !== null));
    }
}
