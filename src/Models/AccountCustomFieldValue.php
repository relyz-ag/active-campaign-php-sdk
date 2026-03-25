<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class AccountCustomFieldValue
{
    public function __construct(
        public readonly int $id,
        public readonly int $accountId,
        public readonly int $customFieldId,
        public readonly string $fieldValue,
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
            accountId: (int) ($data['accountId'] ?? 0),
            customFieldId: (int) ($data['customFieldId'] ?? $data['accountCustomFieldMetumId'] ?? 0),
            fieldValue: $data['fieldValue'] ?? '',
            createdAt: $data['createdTimestamp'] ?? '',
            updatedAt: $data['updatedTimestamp'] ?? '',
        );
    }
}
