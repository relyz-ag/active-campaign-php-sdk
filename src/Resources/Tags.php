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

    public function create(string $name, string $type): Tag
    {
        return $this->create_raw([
            'tag' => $name,
            'tagType' => $type,
        ]);
    }

    public function update(int $id, ?string $name = null, ?string $type = null): Tag
    {
        return $this->update_raw($id, array_filter([
            'tag' => $name,
            'tagType' => $type,
        ], fn ($v) => $v !== null));
    }
}
