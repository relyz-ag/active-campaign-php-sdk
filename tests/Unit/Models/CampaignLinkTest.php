<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\CampaignLink;
use PHPUnit\Framework\TestCase;

final class CampaignLinkTest extends TestCase
{
    public function testFromArray(): void
    {
        $link = CampaignLink::fromArray([
            'id' => '1',
            'campaignid' => '5',
            'messageid' => '3',
            'link' => 'https://example.com',
            'name' => 'Example Link',
            'tracked' => '1',
        ]);

        $this->assertSame(1, $link->id);
        $this->assertSame(5, $link->campaignId);
        $this->assertSame('https://example.com', $link->link);
        $this->assertSame('Example Link', $link->name);
        $this->assertTrue($link->tracked);
    }
}
