<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class ContactTag
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly int $tag,
        public readonly string $createdAt,
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
            tag: (int) $data['tag'],
            createdAt: $data['cdate'] ?? '',
        );
    }
}
