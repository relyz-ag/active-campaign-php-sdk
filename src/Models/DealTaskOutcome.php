<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class DealTaskOutcome
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $sentiment,
        public readonly string $disabled,
        public readonly ?int $createdBy,
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
            sentiment: $data['sentiment'] ?? '',
            disabled: $data['disabled'] ?? '',
            createdBy: isset($data['created_by']) ? (int) $data['created_by'] : null,
        );
    }
}
