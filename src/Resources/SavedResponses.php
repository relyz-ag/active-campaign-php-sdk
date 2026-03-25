<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\SavedResponse;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<SavedResponse>
 */
final class SavedResponses extends Resource
{
    /** @use HasCrud<SavedResponse> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'savedResponses';
    }

    protected function singularKey(): string
    {
        return 'savedResponse';
    }

    protected function pluralKey(): string
    {
        return 'savedResponses';
    }

    protected function modelClass(): string
    {
        return SavedResponse::class;
    }

    public function create(string $title, string $subject, string $body): SavedResponse
    {
        return $this->createRaw([
            'title' => $title,
            'subject' => $subject,
            'body' => $body,
        ]);
    }

    public function update(int $id, ?string $title = null, ?string $subject = null, ?string $body = null): SavedResponse
    {
        return $this->updateRaw($id, array_filter([
            'title' => $title,
            'subject' => $subject,
            'body' => $body,
        ], fn ($v) => $v !== null));
    }
}
