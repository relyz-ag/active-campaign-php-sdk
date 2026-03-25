<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class GeoIp
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly int $campaignId,
        public readonly int $messageId,
        public readonly string $ip4,
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
            contact: (int) $data['contact'],
            campaignId: (int) ($data['campaignid'] ?? 0),
            messageId: (int) ($data['messageid'] ?? 0),
            ip4: $data['ip4'] ?? '',
            timestamp: $data['tstamp'] ?? '',
        );
    }
}
