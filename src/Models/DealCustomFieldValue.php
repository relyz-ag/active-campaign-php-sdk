<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class DealCustomFieldValue
{
    public function __construct(
        public readonly int $id,
        public readonly int $dealId,
        public readonly int $customFieldId,
        public readonly string $fieldValue,
        public readonly ?string $fieldCurrency,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            dealId: (int) $data['dealId'],
            customFieldId: (int) $data['customFieldId'],
            fieldValue: $data['fieldValue'] ?? '',
            fieldCurrency: $data['fieldCurrency'] ?? null,
            createdAt: $data['createdTimestamp'] ?? '',
            updatedAt: $data['updatedTimestamp'] ?? '',
        );
    }
}
