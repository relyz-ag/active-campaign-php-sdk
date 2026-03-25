<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class EcomOrderProduct
{
    public function __construct(
        public readonly int $id,
        public readonly int $orderId,
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $price,
        public readonly int $quantity,
        public readonly ?string $category,
        public readonly ?string $sku,
        public readonly ?string $description,
        public readonly ?string $imageUrl,
        public readonly ?string $productUrl,
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
            orderId: (int) ($data['orderId'] ?? $data['orderid'] ?? 0),
            externalId: $data['externalid'] ?? '',
            name: $data['name'] ?? '',
            price: (int) ($data['price'] ?? 0),
            quantity: (int) ($data['quantity'] ?? 0),
            category: $data['category'] ?? null,
            sku: $data['sku'] ?? null,
            description: $data['description'] ?? null,
            imageUrl: $data['imageUrl'] ?? null,
            productUrl: $data['productUrl'] ?? null,
            createdAt: $data['createdTimestamp'] ?? '',
            updatedAt: $data['updatedTimestamp'] ?? '',
        );
    }
}
