<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\MailingList;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<MailingList>
 */
final class Lists extends Resource
{
    /** @use HasCrud<MailingList> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'lists';
    }
    protected function singularKey(): string
    {
        return 'list';
    }
    protected function pluralKey(): string
    {
        return 'lists';
    }
    protected function modelClass(): string
    {
        return MailingList::class;
    }

    public function create(string $name, string $stringid, ?string $senderUrl = null, ?string $senderReminder = null): MailingList
    {
        return $this->createRaw($this->filterNulls([
            'name' => $name,
            'stringid' => $stringid,
            'sender_url' => $senderUrl,
            'sender_reminder' => $senderReminder,
        ]));
    }

    public function update(int $id, ?string $name = null, ?string $stringid = null, ?string $senderUrl = null, ?string $senderReminder = null): MailingList
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'stringid' => $stringid,
            'sender_url' => $senderUrl,
            'sender_reminder' => $senderReminder,
        ]));
    }
}
