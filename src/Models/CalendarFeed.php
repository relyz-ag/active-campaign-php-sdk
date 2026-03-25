<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class CalendarFeed
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly string $title,
        public readonly string $type,
        public readonly string $token,
        public readonly bool $notification,
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
            userId: (int) ($data['userid'] ?? 0),
            title: $data['title'] ?? '',
            type: $data['type'] ?? '',
            token: $data['token'] ?? '',
            notification: (bool) ($data['notification'] ?? false),
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['mdate'] ?? '',
        );
    }
}
