<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

use ActiveCampaign\Enums\Sentiment;

final class DealTaskOutcome
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?Sentiment $sentiment,
        public readonly ?string $disabled,
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
            sentiment: Sentiment::tryFrom($data['sentiment'] ?? ''),
            disabled: $data['disabled'] ?? null,
            createdBy: isset($data['created_by']) ? (int) $data['created_by'] : null,
        );
    }
}
