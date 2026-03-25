<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class Connection
{
    public function __construct(
        public readonly int $id,
        public readonly string $service,
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $status,
        public readonly string $logoUrl,
        public readonly string $linkUrl,
        public readonly bool $isInternal,
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
            service: $data['service'] ?? '',
            externalId: $data['externalid'] ?? '',
            name: $data['name'] ?? '',
            status: (int) ($data['status'] ?? 0),
            logoUrl: $data['logoUrl'] ?? '',
            linkUrl: $data['linkUrl'] ?? '',
            isInternal: (bool) ($data['isInternal'] ?? false),
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['udate'] ?? '',
        );
    }
}
