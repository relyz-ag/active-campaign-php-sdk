<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\CalendarFeed;
use ActiveCampaign\Resources\Concerns\HasCrud;

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
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'type' => $type,
            'notification' => $notification,
        ]));
    }

    public function update(int $id, ?string $title = null, ?string $type = null, ?bool $notification = null): CalendarFeed
    {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'type' => $type,
            'notification' => $notification,
        ]));
    }
}
