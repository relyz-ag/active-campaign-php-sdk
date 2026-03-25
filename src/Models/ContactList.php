<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class ContactList
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly int $list,
        public readonly int $status,
        public readonly ?string $subscribedAt,
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
            list: (int) $data['list'],
            status: (int) ($data['status'] ?? 0),
            subscribedAt: $data['sdate'] ?? null,
            updatedAt: $data['udate'] ?? $data['updated_timestamp'] ?? null,
        );
    }
}
