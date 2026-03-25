<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class SavedResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $subject,
        public readonly string $body,
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
            title: $data['title'] ?? '',
            subject: $data['subject'] ?? '',
            body: $data['body'] ?? '',
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['mdate'] ?? '',
        );
    }
}
