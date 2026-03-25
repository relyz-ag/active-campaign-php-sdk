<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Meta
{
    public function __construct(
        public readonly int $total,
        public readonly int $limit,
        public readonly int $offset,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            total: (int) ($data['total'] ?? 0),
            limit: (int) ($data['page_input']['limit'] ?? 20),
            offset: (int) ($data['page_input']['offset'] ?? 0),
        );
    }
}
