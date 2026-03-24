<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Automation;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Automation>
 */
final class Automations extends Resource
{
    /** @use HasCrud<Automation> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'automations';
    }
    protected function singularKey(): string
    {
        return 'automation';
    }
    protected function pluralKey(): string
    {
        return 'automations';
    }
    protected function modelClass(): string
    {
        return Automation::class;
    }
}
