<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class Address
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $companyName,
        public readonly ?string $address1,
        public readonly ?string $address2,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $zip,
        public readonly ?string $country,
        public readonly ?string $phone,
        public readonly bool $isDefault,
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
            companyName: $data['companyName'] ?? null,
            address1: $data['address1'] ?? null,
            address2: $data['address2'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            zip: $data['zip'] ?? null,
            country: $data['country'] ?? null,
            phone: $data['phone'] ?? null,
            isDefault: (bool) ($data['isDefault'] ?? false),
            createdAt: $data['createdTimestamp'],
            updatedAt: $data['updatedTimestamp'],
        );
    }
}
