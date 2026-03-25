<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class TrackingEvent
{
    public function __construct(
        public readonly string $name,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
        );
    }
}
