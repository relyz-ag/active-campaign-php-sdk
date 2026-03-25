<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Resources\Webhooks;
use GuzzleHttp\Psr7\Response;

final class WebhooksTest extends ResourceTestCase
{
    public function testListEvents(): void
    {
        $webhooks = $this->makeWebhooks([
            new Response(200, [], (string) json_encode([
                'webhookEvents' => ['subscribe', 'unsubscribe', 'deal_add'],
            ])),
        ]);

        $result = $webhooks->listEvents();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/webhooks/events', $this->history[0]['request']->getUri()->getPath());
        $this->assertSame(['subscribe', 'unsubscribe', 'deal_add'], $result);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeWebhooks(array $responses): Webhooks
    {
        return new Webhooks($this->makeClient($responses));
    }
}
