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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $content, int $relatedId, string $relatedType, ?int $userId = null): Note
    {
        return $this->createRaw($this->filterNulls([
            'note' => $content,
            'relid' => $relatedId,
            'reltype' => $relatedType,
            'userid' => $userId,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $content = null, ?int $relatedId = null, ?string $relatedType = null, ?int $userId = null): Note
    {
        return $this->updateRaw($id, $this->filterNulls([
            'note' => $content,
            'relid' => $relatedId,
            'reltype' => $relatedType,
            'userid' => $userId,
        ]));
    }
}
