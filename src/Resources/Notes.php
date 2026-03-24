<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Note;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Note>
 */
final class Notes extends Resource
{
    /** @use HasCrud<Note> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'notes';
    }
    protected function singularKey(): string
    {
        return 'note';
    }
    protected function pluralKey(): string
    {
        return 'notes';
    }
    protected function modelClass(): string
    {
        return Note::class;
    }
}
