<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit;

use ActiveCampaign\Sdk\ActiveCampaign;
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
    }
}
