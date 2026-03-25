<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class BulkImportResult
{
    public function __construct(
        public readonly bool $success,
        public readonly int $queuedContacts,
        public readonly string $batchId,
        public readonly string $message,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['Success'] ?? false),
            queuedContacts: (int) ($data['queued_contacts'] ?? 0),
            batchId: $data['batchId'] ?? '',
            message: $data['message'] ?? '',
        );
    }
}
