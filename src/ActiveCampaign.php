<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\Accounts;
use ActiveCampaign\Sdk\Resources\Addresses;
use ActiveCampaign\Sdk\Resources\Automations;
use ActiveCampaign\Sdk\Resources\Campaigns;
use ActiveCampaign\Sdk\Resources\Contacts;
use ActiveCampaign\Sdk\Resources\CustomFields;
use ActiveCampaign\Sdk\Resources\Deals;
use ActiveCampaign\Sdk\Resources\DealTasks;
use ActiveCampaign\Sdk\Resources\Forms;
use ActiveCampaign\Sdk\Resources\Lists;
use ActiveCampaign\Sdk\Resources\Notes;
use ActiveCampaign\Sdk\Resources\Segments;
use ActiveCampaign\Sdk\Resources\Tags;
use ActiveCampaign\Sdk\Resources\Users;
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
    private ?CustomFields $customFields = null;
    private ?Notes $notes = null;
    private ?DealTasks $dealTasks = null;
    private ?Users $users = null;
    private ?Forms $forms = null;
    private ?Segments $segments = null;
    private ?Addresses $addresses = null;

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
    public function customFields(): CustomFields
    {
        return $this->customFields ??= new CustomFields($this->client);
    }
    public function notes(): Notes
    {
        return $this->notes ??= new Notes($this->client);
    }
    public function dealTasks(): DealTasks
    {
        return $this->dealTasks ??= new DealTasks($this->client);
    }
    public function users(): Users
    {
        return $this->users ??= new Users($this->client);
    }
    public function forms(): Forms
    {
        return $this->forms ??= new Forms($this->client);
    }
    public function segments(): Segments
    {
        return $this->segments ??= new Segments($this->client);
    }
    public function addresses(): Addresses
    {
        return $this->addresses ??= new Addresses($this->client);
    }
}
