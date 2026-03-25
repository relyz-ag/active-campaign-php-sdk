<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\FieldOption;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(int $field, string $value, string $label, ?bool $isDefault = null, ?int $orderid = null): FieldOption
    {
        return $this->createRaw($this->filterNulls([
            'field' => $field,
            'value' => $value,
            'label' => $label,
            'isdefault' => $isDefault,
            'orderid' => $orderid,
        ]));
    }
}
