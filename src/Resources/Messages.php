<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Message;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Message>
 */
final class Messages extends Resource
{
    /** @use HasCrud<Message> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'messages';
    }

    protected function singularKey(): string
    {
        return 'message';
    }

    protected function pluralKey(): string
    {
        return 'messages';
    }

    protected function modelClass(): string
    {
        return Message::class;
    }

    public function create(string $subject, string $fromName, string $fromEmail, ?string $reply2 = null, ?string $preheaderText = null, ?string $html = null, ?string $text = null): Message
    {
        return $this->create_raw(array_filter([
            'subject' => $subject,
            'fromname' => $fromName,
            'fromemail' => $fromEmail,
            'reply2' => $reply2,
            'preheader_text' => $preheaderText,
            'html' => $html,
            'text' => $text,
        ], fn ($v) => $v !== null));
    }

    public function update(int $id, ?string $subject = null, ?string $fromName = null, ?string $fromEmail = null, ?string $reply2 = null, ?string $preheaderText = null, ?string $html = null, ?string $text = null): Message
    {
        return $this->update_raw($id, array_filter([
            'subject' => $subject,
            'fromname' => $fromName,
            'fromemail' => $fromEmail,
            'reply2' => $reply2,
            'preheader_text' => $preheaderText,
            'html' => $html,
            'text' => $text,
        ], fn ($v) => $v !== null));
    }
}
