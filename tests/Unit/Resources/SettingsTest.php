<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Resources\Settings;
use GuzzleHttp\Psr7\Response;

final class SettingsTest extends ResourceTestCase
{
    public function testUpdateSettings(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'settings' => [
                    'timezone' => 'America/New_York',
                    'trackLinks' => true,
                ],
            ])),
        ]);

        $result = $resource->update([
            'timezone' => 'America/New_York',
            'trackLinks' => true,
        ]);

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/settings', $this->history[0]['request']->getUri()->getPath());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('America/New_York', $body['timezone']);
        $this->assertTrue($body['trackLinks']);
        $this->assertSame('America/New_York', $result['settings']['timezone']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Settings
    {
        return new Settings($this->makeClient($responses));
    }
}
