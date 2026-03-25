<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

/**
 * @extends Resource<mixed>
 */
final class Settings extends Resource
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function update(array $data): array
    {
        return $this->client->put('settings', $data);
    }
}
