<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Note;
use ActiveCampaign\Resources\Concerns\HasCrud;

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

    public function create(string $content, int $relatedId, string $relatedType, ?int $userId = null): Note
    {
        return $this->create_raw(array_filter([
            'note' => $content,
            'relid' => $relatedId,
            'reltype' => $relatedType,
            'userid' => $userId,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $content = null, ?int $relatedId = null, ?string $relatedType = null, ?int $userId = null): Note
    {
        return $this->update_raw($id, array_filter([
            'note' => $content,
            'relid' => $relatedId,
            'reltype' => $relatedType,
            'userid' => $userId,
        ], fn ($v) => $v !== null));
    }
}
