<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class ContactAutomation
{
    public function __construct(
        public readonly int $id,
        public readonly int $contact,
        public readonly int $automation,
        public readonly int $status,
        public readonly int $completed,
        public readonly int $completeValue,
        public readonly ?string $addDate,
        public readonly ?string $removeDate,
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
            automation: (int) ($data['automation'] ?? $data['seriesid'] ?? 0),
            status: (int) ($data['status'] ?? 0),
            completed: (int) ($data['completed'] ?? 0),
            completeValue: (int) ($data['completeValue'] ?? 0),
            addDate: $data['adddate'] ?? null,
            removeDate: $data['remdate'] ?? null,
        );
    }
}
