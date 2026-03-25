<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Template;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Template>
 */
final class Templates extends Resource
{
    /** @use HasCrud<Template> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'templates';
    }

    protected function singularKey(): string
    {
        return 'template';
    }

    protected function pluralKey(): string
    {
        return 'templates';
    }

    protected function modelClass(): string
    {
        return Template::class;
    }
}
