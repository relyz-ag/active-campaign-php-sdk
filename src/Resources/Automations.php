<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Automation;
use ActiveCampaign\Resources\Concerns\HasCrud;

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
        return $this->createRaw(['name' => $name]);
    }

    public function update(int $id, ?string $name = null): Automation
    {
        return $this->updateRaw($id, array_filter([
            'name' => $name,
        ], fn ($v) => $v !== null));
    }
}
