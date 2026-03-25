<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\AccountCustomField;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<AccountCustomField>
 */
final class AccountCustomFields extends Resource
{
    /** @use HasCrud<AccountCustomField> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'accountCustomFieldMeta';
    }

    protected function singularKey(): string
    {
        return 'accountCustomFieldMetum';
    }

    protected function pluralKey(): string
    {
        return 'accountCustomFieldMeta';
    }

    protected function modelClass(): string
    {
        return AccountCustomField::class;
    }

    public function create(string $fieldLabel, string $fieldType, ?string $fieldDefault = null, ?bool $isFormVisible = null, ?int $displayOrder = null): AccountCustomField
    {
        return $this->createRaw($this->filterNulls([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'displayOrder' => $displayOrder,
        ]));
    }

    public function update(int $id, ?string $fieldLabel = null, ?string $fieldType = null, ?string $fieldDefault = null, ?bool $isFormVisible = null, ?int $displayOrder = null): AccountCustomField
    {
        return $this->updateRaw($id, $this->filterNulls([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'displayOrder' => $displayOrder,
        ]));
    }
}
