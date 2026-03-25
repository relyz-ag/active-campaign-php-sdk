<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\FieldOption;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<FieldOption>
 */
final class FieldOptions extends Resource
{
    /** @use HasCrud<FieldOption> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'fieldOptions';
    }

    protected function singularKey(): string
    {
        return 'fieldOption';
    }

    protected function pluralKey(): string
    {
        return 'fieldOptions';
    }

    protected function modelClass(): string
    {
        return FieldOption::class;
    }

    public function create(int $field, string $value, string $label, ?bool $isDefault = null, ?int $orderid = null): FieldOption
    {
        return $this->create_raw(array_filter([
            'field' => $field,
            'value' => $value,
            'label' => $label,
            'isdefault' => $isDefault,
            'orderid' => $orderid,
        ], fn ($v) => $v !== null));
    }
}
