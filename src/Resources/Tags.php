<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Tag;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Tag>
 */
final class Tags extends Resource
{
    /** @use HasCrud<Tag> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'tags';
    }
    protected function singularKey(): string
    {
        return 'tag';
    }
    protected function pluralKey(): string
    {
        return 'tags';
    }
    protected function modelClass(): string
    {
        return Tag::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name, string $type): Tag
    {
        return $this->createRaw([
            'tag' => $name,
            'tagType' => $type,
        ]);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null, ?string $type = null): Tag
    {
        return $this->updateRaw($id, $this->filterNulls([
            'tag' => $name,
            'tagType' => $type,
        ]));
    }
}
