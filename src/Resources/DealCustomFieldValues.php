<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\DealCustomFieldValue;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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

    public function create(
        int $dealId,
        int $customFieldId,
        string $fieldValue,
        ?string $fieldCurrency = null,
    ): DealCustomFieldValue {
        return $this->create_raw(array_filter([
            'dealId' => $dealId,
            'customFieldId' => $customFieldId,
            'fieldValue' => $fieldValue,
            'fieldCurrency' => $fieldCurrency,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $fieldValue = null,
        ?string $fieldCurrency = null,
    ): DealCustomFieldValue {
        return $this->update_raw($id, array_filter([
            'fieldValue' => $fieldValue,
            'fieldCurrency' => $fieldCurrency,
        ], fn ($v) => $v !== null));
    }

    /**
     * @param list<array<string, mixed>> $data
     * @return array<string, mixed>
     */
    public function bulkCreate(array $data): array
    {
        /** @var array<string, mixed> $payload */
        $payload = $data;

        return $this->client->post('dealCustomFieldData/bulkCreate', $payload);
    }
}
