<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Deal;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Deal>
 */
final class Deals extends Resource
{
    /** @use HasCrud<Deal> */
    use HasCrud;

    protected function endpoint(): string { return 'deals'; }
    protected function singularKey(): string { return 'deal'; }
    protected function pluralKey(): string { return 'deals'; }
    protected function modelClass(): string { return Deal::class; }
}
