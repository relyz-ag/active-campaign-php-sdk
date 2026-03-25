<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\FieldValue;
use ActiveCampaign\Resources\FieldValues;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class FieldValuesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'fieldValue' => ['id' => '1', 'contact' => '5', 'field' => '10', 'value' => 'hello', 'cdate' => '2024-01-01', 'udate' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(contact: 5, field: 10, value: 'hello');

        $this->assertInstanceOf(FieldValue::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->contact);
        $this->assertSame(10, $result->field);
        $this->assertSame('hello', $result->value);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldValues', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'fieldValue' => ['id' => '1', 'contact' => '5', 'field' => '10', 'value' => 'updated', 'cdate' => '2024-01-01', 'udate' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, value: 'updated');

        $this->assertInstanceOf(FieldValue::class, $result);
        $this->assertSame('updated', $result->value);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldValues/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): FieldValues
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new FieldValues($client);
    }
}
