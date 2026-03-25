<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Resources\AccountContacts;
use ActiveCampaign\Sdk\Resources\AccountCustomFields;
use ActiveCampaign\Sdk\Resources\AccountCustomFieldValues;
use ActiveCampaign\Sdk\Resources\Accounts;
use ActiveCampaign\Sdk\Resources\Addresses;
use ActiveCampaign\Sdk\Resources\Automations;
use ActiveCampaign\Sdk\Resources\Brandings;
use ActiveCampaign\Sdk\Resources\CalendarFeeds;
use ActiveCampaign\Sdk\Resources\Campaigns;
use ActiveCampaign\Sdk\Resources\Connections;
use ActiveCampaign\Sdk\Resources\Contacts;
use ActiveCampaign\Sdk\Resources\CustomFields;
use ActiveCampaign\Sdk\Resources\CustomObjectRecords;
use ActiveCampaign\Sdk\Resources\CustomObjectSchemas;
use ActiveCampaign\Sdk\Resources\DealCustomFields;
use ActiveCampaign\Sdk\Resources\DealCustomFieldValues;
use ActiveCampaign\Sdk\Resources\DealRoles;
use ActiveCampaign\Sdk\Resources\Deals;
use ActiveCampaign\Sdk\Resources\DealStages;
use ActiveCampaign\Sdk\Resources\DealTaskOutcomes;
use ActiveCampaign\Sdk\Resources\DealTasks;
use ActiveCampaign\Sdk\Resources\DealTaskTypes;
use ActiveCampaign\Sdk\Resources\EcomCustomers;
use ActiveCampaign\Sdk\Resources\EcomOrderProducts;
use ActiveCampaign\Sdk\Resources\EcomOrders;
use ActiveCampaign\Sdk\Resources\EventTracking;
use ActiveCampaign\Sdk\Resources\FieldOptions;
use ActiveCampaign\Sdk\Resources\FieldValues;
use ActiveCampaign\Sdk\Resources\Forms;
use ActiveCampaign\Sdk\Resources\Groups;
use ActiveCampaign\Sdk\Resources\Lists;
use ActiveCampaign\Sdk\Resources\Messages;
use ActiveCampaign\Sdk\Resources\Notes;
use ActiveCampaign\Sdk\Resources\Pipelines;
use ActiveCampaign\Sdk\Resources\SavedResponses;
use ActiveCampaign\Sdk\Resources\Scores;
use ActiveCampaign\Sdk\Resources\Segments;
use ActiveCampaign\Sdk\Resources\Settings;
use ActiveCampaign\Sdk\Resources\SiteTracking;
use ActiveCampaign\Sdk\Resources\Tags;
use ActiveCampaign\Sdk\Resources\Templates;
use ActiveCampaign\Sdk\Resources\Users;
use ActiveCampaign\Sdk\Resources\Webhooks;

final class ActiveCampaign
{
    private Client $client;

    // Existing resources
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

    // Deal resources
    private ?Pipelines $pipelines = null;
    private ?DealStages $dealStages = null;
    private ?DealCustomFields $dealCustomFields = null;
    private ?DealCustomFieldValues $dealCustomFieldValues = null;
    private ?DealRoles $dealRoles = null;
    private ?DealTaskTypes $dealTaskTypes = null;
    private ?DealTaskOutcomes $dealTaskOutcomes = null;

    // Account resources
    private ?AccountContacts $accountContacts = null;
    private ?AccountCustomFields $accountCustomFields = null;
    private ?AccountCustomFieldValues $accountCustomFieldValues = null;

    // Contact field resources
    private ?FieldValues $fieldValues = null;
    private ?FieldOptions $fieldOptions = null;

    // Communication resources
    private ?Messages $messages = null;
    private ?Scores $scores = null;

    // Admin resources
    private ?Groups $groups = null;
    private ?CalendarFeeds $calendarFeeds = null;
    private ?Brandings $brandings = null;
    private ?SavedResponses $savedResponses = null;
    private ?Templates $templates = null;
    private ?Settings $settings = null;

    // E-Commerce resources
    private ?Connections $connections = null;
    private ?EcomCustomers $ecomCustomers = null;
    private ?EcomOrders $ecomOrders = null;
    private ?EcomOrderProducts $ecomOrderProducts = null;

    // Tracking resources
    private ?EventTracking $eventTracking = null;
    private ?SiteTracking $siteTracking = null;

    // Custom Objects
    private ?CustomObjectSchemas $customObjectSchemas = null;

    public function __construct(
        ?string $url = null,
        ?string $apiKey = null,
        int $maxRetries = 3,
    ) {
        $url ??= getenv('ACTIVE_CAMPAIGN_API_URL') ?: null;
        $apiKey ??= getenv('ACTIVE_CAMPAIGN_API_KEY') ?: null;

        if ($url === null) {
            throw new \InvalidArgumentException(
                'ActiveCampaign API URL is required. Pass it to the constructor or set the ACTIVE_CAMPAIGN_API_URL environment variable.'
            );
        }

        if ($apiKey === null) {
            throw new \InvalidArgumentException(
                'ActiveCampaign API key is required. Pass it to the constructor or set the ACTIVE_CAMPAIGN_API_KEY environment variable.'
            );
        }

        $this->client = new Client(
            url: $url,
            apiKey: $apiKey,
            maxRetries: $maxRetries,
        );
    }

    // --- Existing resources ---

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

    // --- Deal resources ---

    public function pipelines(): Pipelines
    {
        return $this->pipelines ??= new Pipelines($this->client);
    }
    public function dealStages(): DealStages
    {
        return $this->dealStages ??= new DealStages($this->client);
    }
    public function dealCustomFields(): DealCustomFields
    {
        return $this->dealCustomFields ??= new DealCustomFields($this->client);
    }
    public function dealCustomFieldValues(): DealCustomFieldValues
    {
        return $this->dealCustomFieldValues ??= new DealCustomFieldValues($this->client);
    }
    public function dealRoles(): DealRoles
    {
        return $this->dealRoles ??= new DealRoles($this->client);
    }
    public function dealTaskTypes(): DealTaskTypes
    {
        return $this->dealTaskTypes ??= new DealTaskTypes($this->client);
    }
    public function dealTaskOutcomes(): DealTaskOutcomes
    {
        return $this->dealTaskOutcomes ??= new DealTaskOutcomes($this->client);
    }

    // --- Account resources ---

    public function accountContacts(): AccountContacts
    {
        return $this->accountContacts ??= new AccountContacts($this->client);
    }
    public function accountCustomFields(): AccountCustomFields
    {
        return $this->accountCustomFields ??= new AccountCustomFields($this->client);
    }
    public function accountCustomFieldValues(): AccountCustomFieldValues
    {
        return $this->accountCustomFieldValues ??= new AccountCustomFieldValues($this->client);
    }

    // --- Contact field resources ---

    public function fieldValues(): FieldValues
    {
        return $this->fieldValues ??= new FieldValues($this->client);
    }
    public function fieldOptions(): FieldOptions
    {
        return $this->fieldOptions ??= new FieldOptions($this->client);
    }

    // --- Communication resources ---

    public function messages(): Messages
    {
        return $this->messages ??= new Messages($this->client);
    }
    public function scores(): Scores
    {
        return $this->scores ??= new Scores($this->client);
    }

    // --- Admin resources ---

    public function groups(): Groups
    {
        return $this->groups ??= new Groups($this->client);
    }
    public function calendarFeeds(): CalendarFeeds
    {
        return $this->calendarFeeds ??= new CalendarFeeds($this->client);
    }
    public function brandings(): Brandings
    {
        return $this->brandings ??= new Brandings($this->client);
    }
    public function savedResponses(): SavedResponses
    {
        return $this->savedResponses ??= new SavedResponses($this->client);
    }
    public function templates(): Templates
    {
        return $this->templates ??= new Templates($this->client);
    }
    public function settings(): Settings
    {
        return $this->settings ??= new Settings($this->client);
    }

    // --- E-Commerce resources ---

    public function connections(): Connections
    {
        return $this->connections ??= new Connections($this->client);
    }
    public function ecomCustomers(): EcomCustomers
    {
        return $this->ecomCustomers ??= new EcomCustomers($this->client);
    }
    public function ecomOrders(): EcomOrders
    {
        return $this->ecomOrders ??= new EcomOrders($this->client);
    }
    public function ecomOrderProducts(): EcomOrderProducts
    {
        return $this->ecomOrderProducts ??= new EcomOrderProducts($this->client);
    }

    // --- Tracking resources ---

    public function eventTracking(): EventTracking
    {
        return $this->eventTracking ??= new EventTracking($this->client);
    }
    public function siteTracking(): SiteTracking
    {
        return $this->siteTracking ??= new SiteTracking($this->client);
    }

    // --- Custom Objects ---

    public function customObjectSchemas(): CustomObjectSchemas
    {
        return $this->customObjectSchemas ??= new CustomObjectSchemas($this->client);
    }
    public function customObjectRecords(string $schemaId): CustomObjectRecords
    {
        return new CustomObjectRecords($this->client, $schemaId);
    }
}
