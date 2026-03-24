<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class Deal
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $value,
        public readonly string $currency,
        public readonly int $stage,
        public readonly int $pipeline,
        public readonly ?int $owner,
        public readonly int $status,
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
            title: $data['title'],
            value: (int) $data['value'],
            currency: $data['currency'],
            stage: (int) $data['stage'],
            pipeline: (int) $data['pipeline'],
            owner: isset($data['owner']) ? (int) $data['owner'] : null,
            status: (int) $data['status'],
            createdAt: $data['cdate'],
            updatedAt: $data['mdate'],
        );
    }
}
