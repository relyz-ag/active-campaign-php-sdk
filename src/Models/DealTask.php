<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class DealTask
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $dealId,
        public readonly int $status,
        public readonly ?string $dueDate,
        public readonly ?int $ownerId,
        public readonly ?string $taskType,
        public readonly string $createdAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: $data['title'],
            dealId: (int) $data['relid'],
            status: (int) $data['status'],
            dueDate: $data['duedate'] ?? null,
            ownerId: isset($data['owner']) ? (int) $data['owner'] : null,
            taskType: $data['tasktype'] ?? null,
            createdAt: $data['cdate'],
        );
    }
}
