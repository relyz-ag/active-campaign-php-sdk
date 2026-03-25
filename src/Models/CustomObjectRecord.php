<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class CustomObjectRecord
{
    /**
     * @param array<string, mixed> $fields
     * @param array<string, mixed> $relationships
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $externalId,
        public readonly string $schemaId,
        public readonly array $fields,
        public readonly array $relationships,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            externalId: $data['externalId'] ?? null,
            schemaId: $data['schemaId'] ?? '',
            fields: $data['fields'] ?? [],
            relationships: $data['relationships'] ?? [],
        );
    }
}
