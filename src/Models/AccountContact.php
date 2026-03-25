<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class AccountContact
{
    public function __construct(
        public readonly int $id,
        public readonly int $account,
        public readonly int $contact,
        public readonly string $jobTitle,
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
            account: (int) $data['account'],
            contact: (int) $data['contact'],
            jobTitle: $data['jobTitle'] ?? '',
            createdAt: $data['createdTimestamp'] ?? '',
            updatedAt: $data['updatedTimestamp'] ?? '',
        );
    }
}
