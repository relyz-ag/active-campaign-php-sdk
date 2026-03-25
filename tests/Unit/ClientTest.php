<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit;

use ActiveCampaign\Client;
use ActiveCampaign\Resources\AccountContacts;
use ActiveCampaign\Resources\AccountCustomFields;
use ActiveCampaign\Resources\AccountCustomFieldValues;
use ActiveCampaign\Resources\Accounts;
use ActiveCampaign\Resources\Addresses;
use ActiveCampaign\Resources\Automations;
use ActiveCampaign\Resources\Brandings;
use ActiveCampaign\Resources\CalendarFeeds;
use ActiveCampaign\Resources\Campaigns;
use ActiveCampaign\Resources\Connections;
use ActiveCampaign\Resources\Contacts;
use ActiveCampaign\Resources\CustomFields;
use ActiveCampaign\Resources\CustomObjectRecords;
use ActiveCampaign\Resources\CustomObjectSchemas;
use ActiveCampaign\Resources\DealCustomFields;
use ActiveCampaign\Resources\DealCustomFieldValues;
use ActiveCampaign\Resources\DealRoles;
use ActiveCampaign\Resources\Deals;
use ActiveCampaign\Resources\DealStages;
use ActiveCampaign\Resources\DealTaskOutcomes;
use ActiveCampaign\Resources\DealTasks;
use ActiveCampaign\Resources\DealTaskTypes;
use ActiveCampaign\Resources\EcomCustomers;
use ActiveCampaign\Resources\EcomOrderProducts;
use ActiveCampaign\Resources\EcomOrders;
use ActiveCampaign\Resources\EventTracking;
use ActiveCampaign\Resources\FieldOptions;
use ActiveCampaign\Resources\FieldValues;
use ActiveCampaign\Resources\Forms;
use ActiveCampaign\Resources\Groups;
use ActiveCampaign\Resources\Lists;
use ActiveCampaign\Resources\Messages;
use ActiveCampaign\Resources\Notes;
use ActiveCampaign\Resources\Pipelines;
use ActiveCampaign\Resources\SavedResponses;
use ActiveCampaign\Resources\Scores;
use ActiveCampaign\Resources\Segments;
use ActiveCampaign\Resources\Settings;
use ActiveCampaign\Resources\SiteTracking;
use ActiveCampaign\Resources\Tags;
use ActiveCampaign\Resources\Templates;
use ActiveCampaign\Resources\Users;
use ActiveCampaign\Resources\Webhooks;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    private Client $ac;

    protected function setUp(): void
    {
        $this->ac = new Client(
            url: 'https://test.api-us1.com',
            apiKey: 'test-key',
        );
    }

    // --- Existing resources ---

    public function testContactsReturnsContactsResource(): void
    {
        $this->assertInstanceOf(Contacts::class, $this->ac->contacts());
    }

    public function testDealsReturnsDealResource(): void
    {
        $this->assertInstanceOf(Deals::class, $this->ac->deals());
    }

    public function testTagsReturnsTagsResource(): void
    {
        $this->assertInstanceOf(Tags::class, $this->ac->tags());
    }

    public function testListsReturnsListsResource(): void
    {
        $this->assertInstanceOf(Lists::class, $this->ac->lists());
    }

    public function testAccountsReturnsAccountsResource(): void
    {
        $this->assertInstanceOf(Accounts::class, $this->ac->accounts());
    }

    public function testAutomationsReturnsAutomationsResource(): void
    {
        $this->assertInstanceOf(Automations::class, $this->ac->automations());
    }

    public function testCampaignsReturnsCampaignsResource(): void
    {
        $this->assertInstanceOf(Campaigns::class, $this->ac->campaigns());
    }

    public function testWebhooksReturnsWebhooksResource(): void
    {
        $this->assertInstanceOf(Webhooks::class, $this->ac->webhooks());
    }

    public function testCustomFieldsReturnsCustomFieldsResource(): void
    {
        $this->assertInstanceOf(CustomFields::class, $this->ac->customFields());
    }

    public function testNotesReturnsNotesResource(): void
    {
        $this->assertInstanceOf(Notes::class, $this->ac->notes());
    }

    public function testDealTasksReturnsDealTasksResource(): void
    {
        $this->assertInstanceOf(DealTasks::class, $this->ac->dealTasks());
    }

    public function testUsersReturnsUsersResource(): void
    {
        $this->assertInstanceOf(Users::class, $this->ac->users());
    }

    public function testFormsReturnsFormsResource(): void
    {
        $this->assertInstanceOf(Forms::class, $this->ac->forms());
    }

    public function testSegmentsReturnsSegmentsResource(): void
    {
        $this->assertInstanceOf(Segments::class, $this->ac->segments());
    }

    public function testAddressesReturnsAddressesResource(): void
    {
        $this->assertInstanceOf(Addresses::class, $this->ac->addresses());
    }

    // --- Deal resources ---

    public function testPipelinesReturnsPipelinesResource(): void
    {
        $this->assertInstanceOf(Pipelines::class, $this->ac->pipelines());
    }

    public function testDealStagesReturnsDealStagesResource(): void
    {
        $this->assertInstanceOf(DealStages::class, $this->ac->dealStages());
    }

    public function testDealCustomFieldsReturnsDealCustomFieldsResource(): void
    {
        $this->assertInstanceOf(DealCustomFields::class, $this->ac->dealCustomFields());
    }

    public function testDealCustomFieldValuesReturnsDealCustomFieldValuesResource(): void
    {
        $this->assertInstanceOf(DealCustomFieldValues::class, $this->ac->dealCustomFieldValues());
    }

    public function testDealRolesReturnsDealRolesResource(): void
    {
        $this->assertInstanceOf(DealRoles::class, $this->ac->dealRoles());
    }

    public function testDealTaskTypesReturnsDealTaskTypesResource(): void
    {
        $this->assertInstanceOf(DealTaskTypes::class, $this->ac->dealTaskTypes());
    }

    public function testDealTaskOutcomesReturnsDealTaskOutcomesResource(): void
    {
        $this->assertInstanceOf(DealTaskOutcomes::class, $this->ac->dealTaskOutcomes());
    }

    // --- Account resources ---

    public function testAccountContactsReturnsAccountContactsResource(): void
    {
        $this->assertInstanceOf(AccountContacts::class, $this->ac->accountContacts());
    }

    public function testAccountCustomFieldsReturnsAccountCustomFieldsResource(): void
    {
        $this->assertInstanceOf(AccountCustomFields::class, $this->ac->accountCustomFields());
    }

    public function testAccountCustomFieldValuesReturnsAccountCustomFieldValuesResource(): void
    {
        $this->assertInstanceOf(AccountCustomFieldValues::class, $this->ac->accountCustomFieldValues());
    }

    // --- Contact field resources ---

    public function testFieldValuesReturnsFieldValuesResource(): void
    {
        $this->assertInstanceOf(FieldValues::class, $this->ac->fieldValues());
    }

    public function testFieldOptionsReturnsFieldOptionsResource(): void
    {
        $this->assertInstanceOf(FieldOptions::class, $this->ac->fieldOptions());
    }

    // --- Communication resources ---

    public function testMessagesReturnsMessagesResource(): void
    {
        $this->assertInstanceOf(Messages::class, $this->ac->messages());
    }

    public function testScoresReturnsScoresResource(): void
    {
        $this->assertInstanceOf(Scores::class, $this->ac->scores());
    }

    // --- Admin resources ---

    public function testGroupsReturnsGroupsResource(): void
    {
        $this->assertInstanceOf(Groups::class, $this->ac->groups());
    }

    public function testCalendarFeedsReturnsCalendarFeedsResource(): void
    {
        $this->assertInstanceOf(CalendarFeeds::class, $this->ac->calendarFeeds());
    }

    public function testBrandingsReturnsBrandingsResource(): void
    {
        $this->assertInstanceOf(Brandings::class, $this->ac->brandings());
    }

    public function testSavedResponsesReturnsSavedResponsesResource(): void
    {
        $this->assertInstanceOf(SavedResponses::class, $this->ac->savedResponses());
    }

    public function testTemplatesReturnsTemplatesResource(): void
    {
        $this->assertInstanceOf(Templates::class, $this->ac->templates());
    }

    public function testSettingsReturnsSettingsResource(): void
    {
        $this->assertInstanceOf(Settings::class, $this->ac->settings());
    }

    // --- E-Commerce resources ---

    public function testConnectionsReturnsConnectionsResource(): void
    {
        $this->assertInstanceOf(Connections::class, $this->ac->connections());
    }

    public function testEcomCustomersReturnsEcomCustomersResource(): void
    {
        $this->assertInstanceOf(EcomCustomers::class, $this->ac->ecomCustomers());
    }

    public function testEcomOrdersReturnsEcomOrdersResource(): void
    {
        $this->assertInstanceOf(EcomOrders::class, $this->ac->ecomOrders());
    }

    public function testEcomOrderProductsReturnsEcomOrderProductsResource(): void
    {
        $this->assertInstanceOf(EcomOrderProducts::class, $this->ac->ecomOrderProducts());
    }

    // --- Tracking resources ---

    public function testEventTrackingReturnsEventTrackingResource(): void
    {
        $this->assertInstanceOf(EventTracking::class, $this->ac->eventTracking());
    }

    public function testSiteTrackingReturnsSiteTrackingResource(): void
    {
        $this->assertInstanceOf(SiteTracking::class, $this->ac->siteTracking());
    }

    // --- Custom Objects ---

    public function testCustomObjectSchemasReturnsCustomObjectSchemasResource(): void
    {
        $this->assertInstanceOf(CustomObjectSchemas::class, $this->ac->customObjectSchemas());
    }

    public function testCustomObjectRecordsReturnsCustomObjectRecordsResource(): void
    {
        $this->assertInstanceOf(CustomObjectRecords::class, $this->ac->customObjectRecords('test-schema'));
    }

    // --- Caching ---

    public function testAccessorsReturnSameInstance(): void
    {
        $this->assertSame($this->ac->contacts(), $this->ac->contacts());
        $this->assertSame($this->ac->deals(), $this->ac->deals());
        $this->assertSame($this->ac->tags(), $this->ac->tags());
        $this->assertSame($this->ac->customFields(), $this->ac->customFields());
        $this->assertSame($this->ac->notes(), $this->ac->notes());
        $this->assertSame($this->ac->dealTasks(), $this->ac->dealTasks());
        $this->assertSame($this->ac->users(), $this->ac->users());
        $this->assertSame($this->ac->forms(), $this->ac->forms());
        $this->assertSame($this->ac->segments(), $this->ac->segments());
        $this->assertSame($this->ac->addresses(), $this->ac->addresses());
        $this->assertSame($this->ac->pipelines(), $this->ac->pipelines());
        $this->assertSame($this->ac->dealStages(), $this->ac->dealStages());
        $this->assertSame($this->ac->dealRoles(), $this->ac->dealRoles());
        $this->assertSame($this->ac->accountContacts(), $this->ac->accountContacts());
        $this->assertSame($this->ac->messages(), $this->ac->messages());
        $this->assertSame($this->ac->scores(), $this->ac->scores());
        $this->assertSame($this->ac->connections(), $this->ac->connections());
        $this->assertSame($this->ac->eventTracking(), $this->ac->eventTracking());
        $this->assertSame($this->ac->customObjectSchemas(), $this->ac->customObjectSchemas());
    }
}
