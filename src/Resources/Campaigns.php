<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Campaign;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Campaign>
 */
final class Campaigns extends Resource
{
    /** @use HasCrud<Campaign> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'campaigns';
    }
    protected function singularKey(): string
    {
        return 'campaign';
    }
    protected function pluralKey(): string
    {
        return 'campaigns';
    }
    protected function modelClass(): string
    {
        return Campaign::class;
    }
}
