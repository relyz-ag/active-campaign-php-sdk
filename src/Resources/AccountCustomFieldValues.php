<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\AccountCustomFieldValue;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<AccountCustomFieldValue>
 */
final class AccountCustomFieldValues extends Resource
{
    /** @use HasCrud<AccountCustomFieldValue> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'accountCustomFieldData';
    }

    protected function singularKey(): string
    {
        return 'accountCustomFieldDatum';
    }

    protected function pluralKey(): string
    {
        return 'accountCustomFieldData';
    }

    protected function modelClass(): string
    {
        return AccountCustomFieldValue::class;
    }

    public function create(int $accountId, int $customFieldId, string $fieldValue): AccountCustomFieldValue
    {
        return $this->createRaw($this->filterNulls([
            'accountId' => $accountId,
            'accountCustomFieldMetumId' => $customFieldId,
            'fieldValue' => $fieldValue,
        ]));
    }

    public function update(int $id, ?string $fieldValue = null): AccountCustomFieldValue
    {
        return $this->updateRaw($id, $this->filterNulls([
            'fieldValue' => $fieldValue,
        ]));
    }

    /**
     * @param list<array<string, mixed>> $data
     * @return list<AccountCustomFieldValue>
     */
    public function bulkCreate(array $data): array
    {
        /** @var array<string, mixed> $payload */
        $payload = $data;
        $response = $this->client->post('accountCustomFieldData/bulkCreate', $payload);

        return array_map(
            fn (array $item) => AccountCustomFieldValue::fromArray($item),
            $response[$this->pluralKey()] ?? [],
        );
    }
}
