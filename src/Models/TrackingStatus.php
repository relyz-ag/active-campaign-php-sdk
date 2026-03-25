<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class TrackingStatus
{
    public function __construct(
        public readonly bool $enabled,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            enabled: (bool) ($data['enabled'] ?? false),
        );
    }
}
