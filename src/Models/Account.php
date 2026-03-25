<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Account
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $accountUrl,
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
            name: $data['name'],
            accountUrl: $data['accountUrl'] ?? null,
            createdAt: $data['createdTimestamp'],
            updatedAt: $data['updatedTimestamp'],
        );
    }
}
