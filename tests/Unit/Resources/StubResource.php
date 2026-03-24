<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Models\Contact;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;
use ActiveCampaign\Sdk\Resources\Resource;

/**
 * @extends Resource<Contact>
 */
final class StubResource extends Resource
{
    /** @use HasCrud<Contact> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'contacts';
    }

    protected function singularKey(): string
    {
        return 'contact';
    }

    protected function pluralKey(): string
    {
        return 'contacts';
    }

    protected function modelClass(): string
    {
        return Contact::class;
    }
}
