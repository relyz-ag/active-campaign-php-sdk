<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class AccountCustomField
{
    public function __construct(
        public readonly int $id,
        public readonly string $fieldLabel,
        public readonly string $fieldType,
        public readonly ?string $fieldDefault,
        public readonly bool $isFormVisible,
        public readonly int $displayOrder,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            fieldLabel: $data['fieldLabel'],
            fieldType: $data['fieldType'],
            fieldDefault: $data['fieldDefault'] ?? null,
            isFormVisible: (bool) ($data['isFormVisible'] ?? false),
            displayOrder: (int) ($data['displayOrder'] ?? 0),
            createdAt: $data['createdTimestamp'] ?? null,
            updatedAt: $data['updatedTimestamp'] ?? null,
        );
    }
}
