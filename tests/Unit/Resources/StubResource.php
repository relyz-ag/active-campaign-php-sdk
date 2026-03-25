<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Contact;
use ActiveCampaign\Resources\Concerns\HasCrud;
use ActiveCampaign\Resources\Resource;

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
