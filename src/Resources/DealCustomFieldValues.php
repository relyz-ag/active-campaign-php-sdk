<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealCustomFieldValue;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealCustomFieldValue>
 */
final class DealCustomFieldValues extends Resource
{
    /** @use HasCrud<DealCustomFieldValue> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealCustomFieldData';
    }
    protected function singularKey(): string
    {
        return 'dealCustomFieldDatum';
    }
    protected function pluralKey(): string
    {
        return 'dealCustomFieldData';
    }
    protected function modelClass(): string
    {
        return DealCustomFieldValue::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        int $dealId,
        int $customFieldId,
        string $fieldValue,
        ?string $fieldCurrency = null,
    ): DealCustomFieldValue {
        return $this->createRaw($this->filterNulls([
            'dealId' => $dealId,
            'customFieldId' => $customFieldId,
            'fieldValue' => $fieldValue,
            'fieldCurrency' => $fieldCurrency,
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
        ?string $fieldValue = null,
        ?string $fieldCurrency = null,
    ): DealCustomFieldValue {
        return $this->updateRaw($id, $this->filterNulls([
            'fieldValue' => $fieldValue,
            'fieldCurrency' => $fieldCurrency,
        ]));
    }

    /**
     * @param list<array<string, mixed>> $data
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function bulkCreate(array $data): array
    {
        /** @var array<string, mixed> $payload */
        $payload = $data;

        return $this->client->post('dealCustomFieldData/bulkCreate', $payload);
    }
}
