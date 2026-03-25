<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Pipeline
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $currency,
        public readonly bool $autoassign,
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
            title: $data['title'],
            currency: $data['currency'],
            autoassign: (bool) ($data['autoassign'] ?? false),
            createdAt: $data['cdate'],
            updatedAt: $data['udate'],
        );
    }
}
