<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Contact
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $phone,
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
            email: $data['email'],
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            createdAt: $data['cdate'],
            updatedAt: $data['udate'],
        );
    }
}
