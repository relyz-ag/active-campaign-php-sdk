<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\Contact;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Contact>
 */
final class Contacts extends Resource
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

    /**
     * @return array<string, mixed>
     */
    public function tag(int $contactId, int $tagId): array
    {
        return $this->client->post('contactTags', [
            'contactTag' => [
                'contact' => $contactId,
                'tag' => $tagId,
            ],
        ]);
    }

    public function untag(int $contactTagId): void
    {
        $this->client->delete('contactTags/' . $contactTagId);
    }
}
