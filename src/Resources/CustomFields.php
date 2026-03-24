<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\CustomField;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<CustomField>
 */
final class CustomFields extends Resource
{
    /** @use HasCrud<CustomField> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'fields';
    }
    protected function singularKey(): string
    {
        return 'field';
    }
    protected function pluralKey(): string
    {
        return 'fields';
    }
    protected function modelClass(): string
    {
        return CustomField::class;
    }
}
