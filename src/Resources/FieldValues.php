<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\FieldValue;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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
        return $this->create_raw(array_filter([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?int $contact = null, ?int $field = null, ?string $value = null): FieldValue
    {
        return $this->update_raw($id, array_filter([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ], fn ($v) => $v !== null));
    }
}
