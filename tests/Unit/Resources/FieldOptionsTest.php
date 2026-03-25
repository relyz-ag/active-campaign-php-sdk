<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\FieldOption;
use ActiveCampaign\Resources\FieldOptions;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class FieldOptionsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'fieldOption' => [
                    'id' => '1',
                    'field' => '3',
                    'value' => 'Option A',
                    'label' => 'Option A Label',
                    'isdefault' => '0',
                    'orderid' => '0',
                    'cdate' => '2024-01-01',
                    'udate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(field: 3, value: 'Option A', label: 'Option A Label');

        $this->assertInstanceOf(FieldOption::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(3, $result->field);
        $this->assertSame('Option A', $result->value);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldOptions', $this->history[0]['request']->getUri()->getPath());
    }

    public function testCreateWithOptionalParams(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'fieldOption' => [
                    'id' => '2',
                    'field' => '3',
                    'value' => 'Option B',
                    'label' => 'Option B Label',
                    'isdefault' => '1',
                    'orderid' => '5',
                    'cdate' => '2024-01-01',
                    'udate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(field: 3, value: 'Option B', label: 'Option B Label', isDefault: true, orderid: 5);

        $this->assertInstanceOf(FieldOption::class, $result);
        $this->assertTrue($result->isDefault);
        $this->assertSame(5, $result->orderid);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertTrue($body['fieldOption']['isdefault']);
        $this->assertSame(5, $body['fieldOption']['orderid']);
    }

    public function testDelete(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->delete(1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldOptions/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): FieldOptions
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new FieldOptions($client);
    }
}
