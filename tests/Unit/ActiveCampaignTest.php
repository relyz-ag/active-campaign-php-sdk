<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit;

use ActiveCampaign\Sdk\ActiveCampaign;
use ActiveCampaign\Sdk\Resources\Contacts;
use PHPUnit\Framework\TestCase;

final class ActiveCampaignTest extends TestCase
{
    public function testContactsReturnsContactsResource(): void
    {
        $ac = new ActiveCampaign(
            url: 'https://test.api-us1.com',
            apiKey: 'test-key',
        );

        $this->assertInstanceOf(Contacts::class, $ac->contacts());
    }

    public function testContactsReturnsSameInstance(): void
    {
        $ac = new ActiveCampaign(
            url: 'https://test.api-us1.com',
            apiKey: 'test-key',
        );

        $this->assertSame($ac->contacts(), $ac->contacts());
    }
}
