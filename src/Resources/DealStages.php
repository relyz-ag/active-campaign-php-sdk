<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\DealStage;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<DealStage>
 */
final class DealStages extends Resource
{
    /** @use HasCrud<DealStage> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'dealStages';
    }
    protected function singularKey(): string
    {
        return 'dealStage';
    }
    protected function pluralKey(): string
    {
        return 'dealStages';
    }
    protected function modelClass(): string
    {
        return DealStage::class;
    }

    public function create(
        string $title,
        int $pipeline,
        ?int $order = null,
        ?string $color = null,
        ?int $width = null,
    ): DealStage {
        return $this->createRaw($this->filterNulls([
            'title' => $title,
            'group' => $pipeline,
            'order' => $order,
            'color' => $color,
            'width' => $width,
        ]));
    }

    public function update(
        int $id,
        ?string $title = null,
        ?int $pipeline = null,
        ?int $order = null,
        ?string $color = null,
        ?int $width = null,
    ): DealStage {
        return $this->updateRaw($id, $this->filterNulls([
            'title' => $title,
            'group' => $pipeline,
            'order' => $order,
            'color' => $color,
            'width' => $width,
        ]));
    }
}
