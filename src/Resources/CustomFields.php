<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\CustomField;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<CustomField>
 */
final class CustomFields extends Resource
{
    /** @use HasCrud<CustomField> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'fields';
    }
    protected function singularKey(): string
    {
        return 'field';
    }
    protected function pluralKey(): string
    {
        return 'fields';
    }
    protected function modelClass(): string
    {
        return CustomField::class;
    }

    public function create(
        string $label,
        string $type,
        ?string $default = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): CustomField {
        return $this->create_raw(array_filter([
            'title' => $label,
            'type' => $type,
            'defval' => $default,
            'show_in_list' => $isFormVisible,
            'isrequired' => $isRequired,
            'ordernum' => $displayOrder,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $label = null,
        ?string $type = null,
        ?string $default = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): CustomField {
        return $this->update_raw($id, array_filter([
            'title' => $label,
            'type' => $type,
            'defval' => $default,
            'show_in_list' => $isFormVisible,
            'isrequired' => $isRequired,
            'ordernum' => $displayOrder,
        ], fn ($v) => $v !== null));
    }
}
