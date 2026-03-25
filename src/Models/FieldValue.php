<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class FieldValue
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly int $field,
        public readonly ?string $value,
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
            contact: (int) $data['contact'],
            field: (int) $data['field'],
            value: $data['value'] ?? null,
            createdAt: $data['cdate'] ?? null,
            updatedAt: $data['udate'] ?? null,
        );
    }
}
