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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(int $contact, int $field, string $value): FieldValue
    {
        return $this->createRaw($this->filterNulls([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?int $contact = null, ?int $field = null, ?string $value = null): FieldValue
    {
        return $this->updateRaw($id, $this->filterNulls([
            'contact' => $contact,
            'field' => $field,
            'value' => $value,
        ]));
    }
}
