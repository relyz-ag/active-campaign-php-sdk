<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

use ActiveCampaign\Enums\CampaignStatus;

final class Campaign
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $type,
        public readonly ?CampaignStatus $status,
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
            name: $data['name'],
            type: $data['type'],
            status: CampaignStatus::tryFrom((int) $data['status']),
            createdAt: $data['cdate'],
            updatedAt: $data['mdate'],
        );
    }
}
