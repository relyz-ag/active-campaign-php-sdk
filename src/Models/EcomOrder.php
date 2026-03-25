<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class EcomOrder
{
    public function __construct(
        public readonly int $id,
        public readonly int $connectionId,
        public readonly int $customerId,
        public readonly string $externalId,
        public readonly string $email,
        public readonly int $totalPrice,
        public readonly string $currency,
        public readonly ?string $orderNumber,
        public readonly string $orderDate,
        public readonly ?string $shippingMethod,
        public readonly int $state,
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
            connectionId: (int) ($data['connectionid'] ?? 0),
            customerId: (int) ($data['customerid'] ?? 0),
            externalId: $data['externalid'] ?? '',
            email: $data['email'] ?? '',
            totalPrice: (int) ($data['totalPrice'] ?? 0),
            currency: $data['currency'] ?? '',
            orderNumber: $data['orderNumber'] ?? null,
            orderDate: $data['orderDate'] ?? $data['externalCreatedDate'] ?? '',
            shippingMethod: $data['shippingMethod'] ?? null,
            state: (int) ($data['state'] ?? 0),
            createdAt: $data['createdDate'] ?? $data['tstamp'] ?? '',
            updatedAt: $data['updatedDate'] ?? '',
        );
    }
}
