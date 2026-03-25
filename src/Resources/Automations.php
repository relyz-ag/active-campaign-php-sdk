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

    public function create(string $name): Automation
    {
        return $this->create_raw(['name' => $name]);
    }

    public function update(int $id, ?string $name = null): Automation
    {
        return $this->update_raw($id, array_filter([
            'name' => $name,
        ], fn ($v) => $v !== null));
    }
}
