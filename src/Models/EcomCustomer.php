<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class EcomCustomer
{
    public function __construct(
        public readonly int $id,
        public readonly int $connectionId,
        public readonly ?string $externalId,
        public readonly ?string $email,
        public readonly int $totalRevenue,
        public readonly int $totalOrders,
        public readonly int $totalProducts,
        public readonly bool $acceptsMarketing,
        public readonly ?string $createdAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            connectionId: (int) ($data['connectionid'] ?? 0),
            externalId: $data['externalid'] ?? null,
            email: $data['email'] ?? null,
            totalRevenue: (int) ($data['totalRevenue'] ?? 0),
            totalOrders: (int) ($data['totalOrders'] ?? 0),
            totalProducts: (int) ($data['totalProducts'] ?? 0),
            acceptsMarketing: (bool) ($data['acceptsMarketing'] ?? false),
            createdAt: $data['tstamp'] ?? null,
        );
    }
}
