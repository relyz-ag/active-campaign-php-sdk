<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Score
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name,
        public readonly ?string $relType,
        public readonly ?string $description,
        public readonly int $status,
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
            name: $data['name'] ?? null,
            relType: $data['reltype'] ?? null,
            description: $data['descript'] ?? null,
            status: (int) ($data['status'] ?? 0),
            createdAt: $data['cdate'] ?? null,
            updatedAt: $data['mdate'] ?? null,
        );
    }
}
