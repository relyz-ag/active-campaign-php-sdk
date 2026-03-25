<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Group
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly bool $isAdmin,
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
            title: $data['title'] ?? null,
            description: $data['descript'] ?? null,
            isAdmin: (bool) ($data['p_admin'] ?? false),
            createdAt: $data['cdate'] ?? null,
            updatedAt: $data['udate'] ?? null,
        );
    }
}
