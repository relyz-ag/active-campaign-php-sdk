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
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(array $data): array
    {
        return $this->client->put('settings', $data);
    }
}
