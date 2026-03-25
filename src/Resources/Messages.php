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

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $subject, string $fromName, string $fromEmail, ?string $reply2 = null, ?string $preheaderText = null, ?string $html = null, ?string $text = null): Message
    {
        return $this->createRaw($this->filterNulls([
            'subject' => $subject,
            'fromname' => $fromName,
            'fromemail' => $fromEmail,
            'reply2' => $reply2,
            'preheader_text' => $preheaderText,
            'html' => $html,
            'text' => $text,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $subject = null, ?string $fromName = null, ?string $fromEmail = null, ?string $reply2 = null, ?string $preheaderText = null, ?string $html = null, ?string $text = null): Message
    {
        return $this->updateRaw($id, $this->filterNulls([
            'subject' => $subject,
            'fromname' => $fromName,
            'fromemail' => $fromEmail,
            'reply2' => $reply2,
            'preheader_text' => $preheaderText,
            'html' => $html,
            'text' => $text,
        ]));
    }
}
