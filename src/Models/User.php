<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
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
            username: $data['username'],
            email: $data['email'],
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            phone: $data['phone'] ?? null,
            createdAt: $data['createdTimestamp'],
            updatedAt: $data['updatedTimestamp'],
        );
    }
}
