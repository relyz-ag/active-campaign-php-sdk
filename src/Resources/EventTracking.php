<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\TrackingEvent;
use ActiveCampaign\Models\TrackingStatus;

/**
 * @extends Resource<mixed>
 */
final class EventTracking extends Resource
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
        $response = $this->client->get('eventTracking');

        return TrackingStatus::fromArray($response['eventTracking']);
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
        $response = $this->client->put('eventTracking', [
            'eventTracking' => [
                'enabled' => true,
            ],
        ]);

        return TrackingStatus::fromArray($response['eventTracking']);
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
        $response = $this->client->put('eventTracking', [
            'eventTracking' => [
                'enabled' => false,
            ],
        ]);

        return TrackingStatus::fromArray($response['eventTracking']);
    }

    /**
     * @return list<TrackingEvent>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listEvents(): array
    {
        $response = $this->client->get('eventTrackingEvents');

        return array_map(
            fn (array $item) => TrackingEvent::fromArray($item),
            $response['eventTrackingEvents'] ?? [],
        );
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function createEvent(string $name): TrackingEvent
    {
        $response = $this->client->post('eventTrackingEvents', [
            'eventTrackingEvent' => [
                'name' => $name,
            ],
        ]);

        return TrackingEvent::fromArray($response['eventTrackingEvent']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function deleteEvent(string $name): void
    {
        $this->client->delete('eventTrackingEvents/' . $name);
    }
}
