<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\DealTaskType;
use ActiveCampaign\Sdk\Resources\DealTaskTypes;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DealTaskTypesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateReturnsDealTaskTypeModel(): void
    {
        $types = $this->makeDealTaskTypes([
            new Response(201, [], (string) json_encode([
                'dealTasktype' => [
                    'id' => '1',
                    'title' => 'Follow Up',
                    'status' => '1',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $types->create(title: 'Follow Up');

        $this->assertInstanceOf(DealTaskType::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Follow Up', $result->title);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealTasktypes', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsDealTaskTypeModel(): void
    {
        $types = $this->makeDealTaskTypes([
            new Response(200, [], (string) json_encode([
                'dealTasktype' => [
                    'id' => '1',
                    'title' => 'Updated Type',
                    'status' => '0',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $types->update(id: 1, title: 'Updated Type', status: 0);

        $this->assertInstanceOf(DealTaskType::class, $result);
        $this->assertSame('Updated Type', $result->title);
        $this->assertSame(0, $result->status);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealTasktypes/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealTaskTypes(array $responses): DealTaskTypes
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new DealTaskTypes($client);
    }
}
