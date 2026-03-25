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
    public function getStatus(): TrackingStatus
    {
        $response = $this->client->get('siteTracking');

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    public function enable(): TrackingStatus
    {
        $response = $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => true,
            ],
        ]);

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    public function disable(): TrackingStatus
    {
        $response = $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => false,
            ],
        ]);

        return TrackingStatus::fromArray($response['siteTracking']);
    }

    public function addWhitelistDomain(string $name): SiteTrackingDomain
    {
        $response = $this->client->post('siteTrackingDomains', [
            'siteTrackingDomain' => [
                'name' => $name,
            ],
        ]);

        return SiteTrackingDomain::fromArray($response['siteTrackingDomain']);
    }

    public function removeWhitelistDomain(string $name): void
    {
        $this->client->delete('siteTrackingDomains/' . $name);
    }

    /**
     * @return list<SiteTrackingDomain>
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
