<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Form;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Form>
 */
final class Forms extends Resource
{
    /** @use HasCrud<Form> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'forms';
    }
    protected function singularKey(): string
    {
        return 'form';
    }
    protected function pluralKey(): string
    {
        return 'forms';
    }
    protected function modelClass(): string
    {
        return Form::class;
    }

    public function create(string $name, ?string $type = null): Form
    {
        return $this->create_raw(array_filter([
            'name' => $name,
            'type' => $type,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $name = null, ?string $type = null): Form
    {
        return $this->update_raw($id, array_filter([
            'name' => $name,
            'type' => $type,
        ], fn ($v) => $v !== null));
    }
}
