<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class MailingList
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $stringid,
        public readonly ?string $senderUrl,
        public readonly ?string $senderReminder,
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
            stringid: $data['stringid'],
            senderUrl: $data['sender_url'] ?? null,
            senderReminder: $data['sender_reminder'] ?? null,
            createdAt: $data['cdate'],
            updatedAt: $data['udate'] ?? $data['cdate'],
        );
    }
}
