<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class BounceLog
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly string $email,
        public readonly string $error,
        public readonly string $source,
        public readonly string $timestamp,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            contact: (int) ($data['contact'] ?? $data['subscriberid'] ?? 0),
            email: $data['email'] ?? '',
            error: $data['error'] ?? '',
            source: $data['source'] ?? '',
            timestamp: $data['tstamp'] ?? '',
        );
    }
}
