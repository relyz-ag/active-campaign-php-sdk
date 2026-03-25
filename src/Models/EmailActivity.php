<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class EmailActivity
{
    public function __construct(
        public readonly string $timestamp,
        public readonly string $type,
        public readonly int $subscriberId,
        public readonly int $campaignId,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            timestamp: $data['tstamp'],
            type: $data['type'],
            subscriberId: (int) $data['subscriberid'],
            campaignId: (int) $data['campaignid'],
        );
    }
}
