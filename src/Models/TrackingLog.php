<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class TrackingLog
{
    public function __construct(
        public readonly int $subscriberId,
        public readonly string $type,
        public readonly string $value,
        public readonly string $timestamp,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriberId: (int) $data['subscriberid'],
            type: $data['type'],
            value: $data['value'],
            timestamp: $data['tstamp'],
        );
    }
}
