<?php

declare(strict_types=1);

namespace ActiveCampaign\Exceptions;

class ActiveCampaignException extends \RuntimeException
{
    /** @var array<string, mixed> */
    private array $responseBody;

    /**
     * @param array<string, mixed> $responseBody
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?\Throwable $previous = null,
        array $responseBody = [],
    ) {
        parent::__construct($message, $code, $previous);
        $this->responseBody = $responseBody;
    }

    /**
     * @return array<string, mixed>
     */
    public function getResponseBody(): array
    {
        return $this->responseBody;
    }
}
