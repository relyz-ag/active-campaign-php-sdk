<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Segment
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $seriesId,
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
            name: $data['name'],
            seriesId: isset($data['seriesid']) ? (int) $data['seriesid'] : null,
            createdAt: $data['cdate'],
        );
    }
}
