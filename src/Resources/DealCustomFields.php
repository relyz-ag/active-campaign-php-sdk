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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $fieldLabel,
        string $fieldType,
        ?string $fieldDefault = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): DealCustomField {
        return $this->createRaw($this->filterNulls([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'isRequired' => $isRequired,
            'displayOrder' => $displayOrder,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(
        int $id,
        ?string $fieldLabel = null,
        ?string $fieldType = null,
        ?string $fieldDefault = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): DealCustomField {
        return $this->updateRaw($id, $this->filterNulls([
            'fieldLabel' => $fieldLabel,
            'fieldType' => $fieldType,
            'fieldDefault' => $fieldDefault,
            'isFormVisible' => $isFormVisible,
            'isRequired' => $isRequired,
            'displayOrder' => $displayOrder,
        ]));
    }
}
