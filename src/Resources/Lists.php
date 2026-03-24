<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\MailingList;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<MailingList>
 */
final class Lists extends Resource
{
    /** @use HasCrud<MailingList> */
    use HasCrud;

    protected function endpoint(): string { return 'lists'; }
    protected function singularKey(): string { return 'list'; }
    protected function pluralKey(): string { return 'lists'; }
    protected function modelClass(): string { return MailingList::class; }
}
