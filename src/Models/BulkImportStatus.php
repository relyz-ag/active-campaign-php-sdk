<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class BulkImportStatus
{
    /**
     * @param list<string> $successIds
     * @param list<string> $failedEmails
     */
    public function __construct(
        public readonly string $status,
        public readonly array $successIds,
        public readonly array $failedEmails,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'] ?? '',
            successIds: $data['success'] ?? [],
            failedEmails: $data['failure'] ?? [],
        );
    }
}
