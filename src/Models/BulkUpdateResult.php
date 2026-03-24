<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class BulkUpdateResult
{
    /**
     * @param list<string> $success
     * @param list<string> $nochange
     * @param list<string> $failed
     */
    public function __construct(
        public readonly array $success,
        public readonly array $nochange,
        public readonly array $failed,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            success: $data['success'] ?? [],
            nochange: $data['nochange'] ?? [],
            failed: $data['failed'] ?? [],
        );
    }
}
