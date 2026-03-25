<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class DealTaskType
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $status,
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
            status: (int) ($data['status'] ?? 0),
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['udate'] ?? '',
        );
    }
}
