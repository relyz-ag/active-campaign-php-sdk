<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Http\Client;

/**
 * @template T
 */
abstract class Resource
{
    public function __construct(
        protected readonly Client $client,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function filterNulls(array $data): array
    {
        return array_filter($data, fn ($v) => $v !== null);
    }
}
