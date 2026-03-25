<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Score;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Score>
 */
final class Scores extends Resource
{
    /** @use HasCrud<Score> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'scores';
    }

    protected function singularKey(): string
    {
        return 'score';
    }

    protected function pluralKey(): string
    {
        return 'scores';
    }

    protected function modelClass(): string
    {
        return Score::class;
    }
}
