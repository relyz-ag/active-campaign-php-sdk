<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class Message
{
    public function __construct(
        public readonly int $id,
        public readonly string $subject,
        public readonly string $fromName,
        public readonly string $fromEmail,
        public readonly string $reply2,
        public readonly ?string $preheaderText,
        public readonly ?string $html,
        public readonly ?string $text,
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
            subject: $data['subject'] ?? '',
            fromName: $data['fromname'] ?? '',
            fromEmail: $data['fromemail'] ?? '',
            reply2: $data['reply2'] ?? '',
            preheaderText: $data['preheader_text'] ?? null,
            html: $data['html'] ?? null,
            text: $data['text'] ?? null,
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['mdate'] ?? '',
        );
    }
}
