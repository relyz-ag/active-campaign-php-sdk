<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealCustomField;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealCustomField>
 */
final class DealCustomFields extends Resource
{
    /** @use HasCrud<DealCustomField> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealCustomFieldMeta';
    }
    protected function singularKey(): string
    {
        return 'dealCustomFieldMetum';
    }
    protected function pluralKey(): string
    {
        return 'dealCustomFieldMeta';
    }
    protected function modelClass(): string
    {
        return DealCustomField::class;
    }

    public function create(
        string $fieldLabel,
        string $fieldType,
        ?string $fieldDefault = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): DealCustomField {
        return $this->create_raw(array_filter([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'isRequired' => $isRequired,
            'displayOrder' => $displayOrder,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $fieldLabel = null,
        ?string $fieldType = null,
        ?string $fieldDefault = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): DealCustomField {
        return $this->update_raw($id, array_filter([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'isRequired' => $isRequired,
            'displayOrder' => $displayOrder,
        ], fn ($v) => $v !== null));
    }
}
