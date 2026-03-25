<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class DealStage
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $pipeline,
        public readonly int $order,
        public readonly ?string $color,
        public readonly int $width,
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
            pipeline: (int) $data['group'],
            order: (int) ($data['order'] ?? 0),
            color: $data['color'] ?? null,
            width: (int) ($data['width'] ?? 280),
            createdAt: $data['cdate'],
            updatedAt: $data['udate'],
        );
    }
}
