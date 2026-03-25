<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class CustomField
{
    public function __construct(
        public readonly int $id,
        public readonly string $label,
        public readonly string $type,
        public readonly ?string $default,
        public readonly bool $isFormVisible,
        public readonly bool $isRequired,
        public readonly int $displayOrder,
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
            label: $data['fieldLabel'],
            type: $data['fieldType'],
            default: $data['fieldDefault'] ?? null,
            isFormVisible: (bool) ($data['isFormVisible'] ?? false),
            isRequired: (bool) ($data['isRequired'] ?? false),
            displayOrder: (int) ($data['displayOrder'] ?? 0),
            createdAt: $data['createdTimestamp'],
            updatedAt: $data['updatedTimestamp'],
        );
    }
}
