<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

/**
 * @extends Resource<mixed>
 */
final class EventTracking extends Resource
{
    /**
     * @return array<string, mixed>
     */
    public function getStatus(): array
    {
        return $this->client->get('eventTracking');
    }

    /**
     * @return array<string, mixed>
     */
    public function enable(): array
    {
        return $this->client->put('eventTracking', [
            'eventTracking' => [
                'enabled' => true,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function disable(): array
    {
        return $this->client->put('eventTracking', [
            'eventTracking' => [
                'enabled' => false,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function listEvents(): array
    {
        return $this->client->get('eventTrackingEvents');
    }

    /**
     * @return array<string, mixed>
     */
    public function createEvent(string $name): array
    {
        return $this->client->post('eventTrackingEvents', [
            'eventTrackingEvent' => [
                'name' => $name,
            ],
        ]);
    }

    public function deleteEvent(string $name): void
    {
        $this->client->delete('eventTrackingEvents/' . $name);
    }
}
