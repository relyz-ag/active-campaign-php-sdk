<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Connection
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $service,
        public readonly ?string $externalId,
        public readonly ?string $name,
        public readonly int $status,
        public readonly ?string $logoUrl,
        public readonly ?string $linkUrl,
        public readonly bool $isInternal,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            service: $data['service'] ?? null,
            externalId: $data['externalid'] ?? null,
            name: $data['name'] ?? null,
            status: (int) ($data['status'] ?? 0),
            logoUrl: $data['logoUrl'] ?? null,
            linkUrl: $data['linkUrl'] ?? null,
            isInternal: (bool) ($data['isInternal'] ?? false),
            createdAt: $data['cdate'] ?? null,
            updatedAt: $data['udate'] ?? null,
        );
    }
}
