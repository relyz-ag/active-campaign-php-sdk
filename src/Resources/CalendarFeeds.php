<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\CalendarFeed;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<CalendarFeed>
 */
final class CalendarFeeds extends Resource
{
    /** @use HasCrud<CalendarFeed> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'calendars';
    }

    protected function singularKey(): string
    {
        return 'calendar';
    }

    protected function pluralKey(): string
    {
        return 'calendars';
    }

    protected function modelClass(): string
    {
        return CalendarFeed::class;
    }

    public function create(string $title, string $type, ?bool $notification = null): CalendarFeed
    {
        return $this->create_raw(array_filter([
            'title' => $title,
            'type' => $type,
            'notification' => $notification,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $title = null, ?string $type = null, ?bool $notification = null): CalendarFeed
    {
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'type' => $type,
            'notification' => $notification,
        ], fn ($v) => $v !== null));
    }
}
