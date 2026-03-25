<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class DealRole
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
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
            title: $data['title'],
            createdAt: $data['created_timestamp'] ?? null,
            updatedAt: $data['updated_timestamp'] ?? null,
        );
    }
}
