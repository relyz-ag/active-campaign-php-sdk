<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Template
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $subject,
        public readonly ?int $categoryId,
        public readonly bool $hidden,
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
            name: $data['name'] ?? '',
            subject: $data['subject'] ?? null,
            categoryId: isset($data['categoryid']) ? (int) $data['categoryid'] : null,
            hidden: (bool) ($data['hidden'] ?? false),
            updatedAt: $data['mdate'] ?? '',
        );
    }
}
