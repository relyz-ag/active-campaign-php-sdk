<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class Webhook
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $url,
        public readonly string $listid,
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
            name: $data['name'],
            url: $data['url'],
            listid: $data['listid'],
            createdAt: $data['cdate'],
            updatedAt: $data['udate'] ?? $data['cdate'],
        );
    }
}
