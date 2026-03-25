<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\FieldValue;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<FieldValue>
 */
final class FieldValues extends Resource
{
    /** @use HasCrud<FieldValue> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'fieldValues';
    }

    protected function singularKey(): string
    {
        return 'fieldValue';
    }

    protected function pluralKey(): string
    {
        return 'fieldValues';
    }

    protected function modelClass(): string
    {
        return FieldValue::class;
    }

    public function create(int $contact, int $field, string $value): FieldValue
    {
        return $this->createRaw(array_filter([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?int $contact = null, ?int $field = null, ?string $value = null): FieldValue
    {
        return $this->updateRaw($id, array_filter([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ], fn ($v) => $v !== null));
    }
}
