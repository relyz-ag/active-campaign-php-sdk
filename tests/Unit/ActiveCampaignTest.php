<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit;

use ActiveCampaign\Sdk\ActiveCampaign;
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
use PHPUnit\Framework\TestCase;

final class ActiveCampaignTest extends TestCase
{
    private ActiveCampaign $ac;

    protected function setUp(): void
    {
        $this->ac = new ActiveCampaign(
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
