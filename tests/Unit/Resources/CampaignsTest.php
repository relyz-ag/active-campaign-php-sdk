<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Campaign;
use ActiveCampaign\Models\CampaignLink;
use ActiveCampaign\Resources\Campaigns;
use GuzzleHttp\Psr7\Response;

final class CampaignsTest extends ResourceTestCase
{
    public function testDuplicate(): void
    {
        $campaigns = $this->makeCampaigns([
            new Response(200, [], (string) json_encode([
                'campaign' => ['id' => '2', 'name' => 'Copy of Campaign', 'type' => 'single', 'status' => '0', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01'],
            ])),
        ]);

        $result = $campaigns->duplicate(1);

        $this->assertInstanceOf(Campaign::class, $result);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/campaigns/1/duplicate', $this->history[0]['request']->getUri()->getPath());
    }

    public function testGetLinks(): void
    {
        $campaigns = $this->makeCampaigns([
            new Response(200, [], (string) json_encode([
                'links' => [['id' => '1', 'campaignid' => '5', 'messageid' => '3', 'link' => 'https://example.com', 'name' => 'Example', 'tracked' => '1']],
            ])),
        ]);

        $result = $campaigns->getLinks(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(CampaignLink::class, $result[0]);
        $this->assertSame('https://example.com', $result[0]->link);
        $this->assertSame('Example', $result[0]->name);
        $this->assertTrue($result[0]->tracked);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeCampaigns(array $responses): Campaigns
    {
        return new Campaigns($this->makeClient($responses));
    }
}
