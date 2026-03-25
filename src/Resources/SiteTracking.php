<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

/**
 * @extends Resource<mixed>
 */
final class SiteTracking extends Resource
{
    /**
     * @return array<string, mixed>
     */
    public function getStatus(): array
    {
        return $this->client->get('siteTracking');
    }

    /**
     * @return array<string, mixed>
     */
    public function enable(): array
    {
        return $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => true,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function disable(): array
    {
        return $this->client->put('siteTracking', [
            'siteTracking' => [
                'enabled' => false,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function addWhitelistDomain(string $name): array
    {
        return $this->client->post('siteTrackingDomains', [
            'siteTrackingDomain' => [
                'name' => $name,
            ],
        ]);
    }

    public function removeWhitelistDomain(string $name): void
    {
        $this->client->delete('siteTrackingDomains/' . $name);
    }

    /**
     * @return array<string, mixed>
     */
    public function listWhitelistDomains(): array
    {
        return $this->client->get('siteTrackingDomains');
    }
}
