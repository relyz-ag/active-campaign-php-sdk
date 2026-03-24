<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Tag;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

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
}
