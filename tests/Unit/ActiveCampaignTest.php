<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit;

use ActiveCampaign\Sdk\ActiveCampaign;
use ActiveCampaign\Sdk\Resources\Accounts;
use ActiveCampaign\Sdk\Resources\Automations;
use ActiveCampaign\Sdk\Resources\Campaigns;
use ActiveCampaign\Sdk\Resources\Contacts;
use ActiveCampaign\Sdk\Resources\Deals;
use ActiveCampaign\Sdk\Resources\Lists;
use ActiveCampaign\Sdk\Resources\Tags;
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

    public function testAccessorsReturnSameInstance(): void
    {
        $this->assertSame($this->ac->contacts(), $this->ac->contacts());
        $this->assertSame($this->ac->deals(), $this->ac->deals());
        $this->assertSame($this->ac->tags(), $this->ac->tags());
    }
}
