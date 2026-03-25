<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class ContactDeal
{
    public function __construct(
        public readonly int $id,
        public readonly int $deal,
        public readonly int $contact,
        public readonly int $role,
        public readonly ?string $createdAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            deal: (int) $data['deal'],
            contact: (int) $data['contact'],
            role: (int) ($data['role'] ?? 0),
            createdAt: $data['cdate'] ?? null,
        );
    }
}
