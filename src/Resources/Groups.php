<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Group;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Group>
 */
final class Groups extends Resource
{
    /** @use HasCrud<Group> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'groups';
    }

    protected function singularKey(): string
    {
        return 'group';
    }

    protected function pluralKey(): string
    {
        return 'groups';
    }

    protected function modelClass(): string
    {
        return Group::class;
    }

    public function create(string $title, ?string $description = null): Group
    {
        return $this->create_raw(array_filter([
            'title' => $title,
            'descript' => $description,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $title = null, ?string $description = null): Group
    {
        return $this->update_raw($id, array_filter([
            'title' => $title,
            'descript' => $description,
        ], fn ($v) => $v !== null));
    }

    /**
     * @return array<string, mixed>
     */
    public function listLimits(): array
    {
        return $this->client->get('groups/limits');
    }
}
