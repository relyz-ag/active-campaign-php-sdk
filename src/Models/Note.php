<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Note
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly int $relatedId,
        public readonly string $relatedType,
        public readonly ?int $userId,
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
            content: $data['note'],
            relatedId: (int) $data['relid'],
            relatedType: $data['reltype'],
            userId: isset($data['userid']) ? (int) $data['userid'] : null,
            createdAt: $data['cdate'],
            updatedAt: $data['mdate'],
        );
    }
}
