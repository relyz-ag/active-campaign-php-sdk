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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $label,
        string $type,
        ?string $default = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): CustomField {
        return $this->createRaw($this->filterNulls([
            'title' => $label,
            'type' => $type,
            'defval' => $default,
            'show_in_list' => $isFormVisible,
            'isrequired' => $isRequired,
            'ordernum' => $displayOrder,
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
        ?string $label = null,
        ?string $type = null,
        ?string $default = null,
        ?bool $isFormVisible = null,
        ?bool $isRequired = null,
        ?int $displayOrder = null,
    ): CustomField {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $label,
            'type' => $type,
            'defval' => $default,
            'show_in_list' => $isFormVisible,
            'isrequired' => $isRequired,
            'ordernum' => $displayOrder,
        ]));
    }
}
