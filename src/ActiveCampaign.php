<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\Accounts;
use ActiveCampaign\Sdk\Resources\Automations;
use ActiveCampaign\Sdk\Resources\Campaigns;
use ActiveCampaign\Sdk\Resources\Contacts;
use ActiveCampaign\Sdk\Resources\Deals;
use ActiveCampaign\Sdk\Resources\Lists;
use ActiveCampaign\Sdk\Resources\Tags;
use ActiveCampaign\Sdk\Resources\Webhooks;

final class ActiveCampaign
{
    private Client $client;
    private ?Contacts $contacts = null;
    private ?Deals $deals = null;
    private ?Tags $tags = null;
    private ?Lists $lists = null;
    private ?Accounts $accounts = null;
    private ?Automations $automations = null;
    private ?Campaigns $campaigns = null;
    private ?Webhooks $webhooks = null;

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
    public function deals(): Deals
    {
        return $this->deals ??= new Deals($this->client);
    }
    public function tags(): Tags
    {
        return $this->tags ??= new Tags($this->client);
    }
    public function lists(): Lists
    {
        return $this->lists ??= new Lists($this->client);
    }
    public function accounts(): Accounts
    {
        return $this->accounts ??= new Accounts($this->client);
    }
    public function automations(): Automations
    {
        return $this->automations ??= new Automations($this->client);
    }
    public function campaigns(): Campaigns
    {
        return $this->campaigns ??= new Campaigns($this->client);
    }
    public function webhooks(): Webhooks
    {
        return $this->webhooks ??= new Webhooks($this->client);
    }
}
