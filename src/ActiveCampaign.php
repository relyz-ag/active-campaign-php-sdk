<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\Contacts;

final class ActiveCampaign
{
    private Client $client;
    private ?Contacts $contacts = null;

    public function __construct(
        string $url,
        string $apiKey,
        int $maxRetries = 3,
    ) {
        $this->client = new Client(
            url: $url,
            apiKey: $apiKey,
            maxRetries: $maxRetries,
        );
    }

    public function contacts(): Contacts
    {
        return $this->contacts ??= new Contacts($this->client);
    }
}
