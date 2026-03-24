<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class CampaignLink
{
    public function __construct(
        public readonly int $id,
        public readonly int $campaignId,
        public readonly int $messageId,
        public readonly string $link,
        public readonly string $name,
        public readonly bool $tracked,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            campaignId: (int) ($data['campaignid'] ?? $data['campaign'] ?? 0),
            messageId: (int) ($data['messageid'] ?? $data['message'] ?? 0),
            link: $data['link'] ?? '',
            name: $data['name'] ?? '',
            tracked: (bool) ($data['tracked'] ?? false),
        );
    }
}
