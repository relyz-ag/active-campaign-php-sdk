<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class CustomObjectSchema
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly ?string $singularLabel,
        public readonly ?string $pluralLabel,
        public readonly string $visibility,
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
            id: $data['id'],
            slug: $data['slug'] ?? null,
            description: $data['description'] ?? null,
            singularLabel: $data['labels']['singular'] ?? null,
            pluralLabel: $data['labels']['plural'] ?? null,
            visibility: $data['visibility'] ?? 'private',
            createdAt: $data['createdTimestamp'] ?? null,
            updatedAt: $data['updatedTimestamp'] ?? null,
        );
    }
}
