<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\SiteTrackingDomain;
use ActiveCampaign\Models\TrackingStatus;

/**
 * @extends Resource<mixed>
 */
final class SiteTracking extends Resource
{
    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function getStatus(): TrackingStatus
    {
        $response = $this->client->get('siteTracking');

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function enable(): TrackingStatus
    {
        $response = $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => true,
            ],
        ]);

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function disable(): TrackingStatus
    {
        $response = $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => false,
            ],
        ]);

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function addWhitelistDomain(string $name): SiteTrackingDomain
    {
        $response = $this->client->post('siteTrackingDomains', [
            'siteTrackingDomain' => [
                'name' => $name,
            ],
        ]);

        return SiteTrackingDomain::fromArray($response['siteTrackingDomain']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function removeWhitelistDomain(string $name): void
    {
        $this->client->delete('siteTrackingDomains/' . $name);
    }

    /**
     * @return list<SiteTrackingDomain>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listWhitelistDomains(): array
    {
        $response = $this->client->get('siteTrackingDomains');

        return array_map(
            fn (array $item) => SiteTrackingDomain::fromArray($item),
            $response['siteTrackingDomains'] ?? [],
        );
    }
}
