<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

final class Branding
{
    public function __construct(
        public readonly int $id,
        public readonly int $groupId,
        public readonly string $siteName,
        public readonly string $siteLogo,
        public readonly string $siteLogoSmall,
        public readonly string $headerTextValue,
        public readonly string $footerTextValue,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            groupId: (int) ($data['groupid'] ?? 0),
            siteName: $data['siteName'] ?? '',
            siteLogo: $data['siteLogo'] ?? '',
            siteLogoSmall: $data['siteLogoSmall'] ?? '',
            headerTextValue: $data['headerTextValue'] ?? '',
            footerTextValue: $data['footerTextValue'] ?? '',
        );
    }
}
