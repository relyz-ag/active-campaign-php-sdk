<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class FieldOption
{
    public function __construct(
        public readonly int $id,
        public readonly int $field,
        public readonly string $value,
        public readonly string $label,
        public readonly bool $isDefault,
        public readonly int $orderid,
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
            field: (int) $data['field'],
            value: $data['value'] ?? '',
            label: $data['label'] ?? '',
            isDefault: (bool) ($data['isdefault'] ?? false),
            orderid: (int) ($data['orderid'] ?? 0),
            createdAt: $data['cdate'] ?? '',
            updatedAt: $data['udate'] ?? '',
        );
    }
}
