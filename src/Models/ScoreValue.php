<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class ScoreValue
{
    public function __construct(
        public readonly int $id,
        public readonly int $score,
        public readonly int $contact,
        public readonly ?int $deal,
        public readonly int $scoreValue,
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
            score: (int) $data['score'],
            contact: (int) $data['contact'],
            deal: isset($data['deal']) ? (int) $data['deal'] : null,
            scoreValue: (int) ($data['scoreValue'] ?? 0),
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['mdate'] ?? '',
        );
    }
}
