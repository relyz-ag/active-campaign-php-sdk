<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Pipeline;
use ActiveCampaign\Sdk\Resources\Pipelines;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PipelinesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateReturnsPipelineModel(): void
    {
        $pipelines = $this->makePipelines([
            new Response(201, [], (string) json_encode([
                'dealGroup' => [
                    'id' => '1',
                    'title' => 'Sales Pipeline',
                    'currency' => 'usd',
                    'autoassign' => '1',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $pipelines->create(title: 'Sales Pipeline', currency: 'usd', autoassign: true);

        $this->assertInstanceOf(Pipeline::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Sales Pipeline', $result->title);
        $this->assertSame('usd', $result->currency);
        $this->assertTrue($result->autoassign);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealGroups', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsPipelineModel(): void
    {
        $pipelines = $this->makePipelines([
            new Response(200, [], (string) json_encode([
                'dealGroup' => [
                    'id' => '1',
                    'title' => 'Updated Pipeline',
                    'currency' => 'eur',
                    'autoassign' => '0',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $pipelines->update(id: 1, title: 'Updated Pipeline', currency: 'eur');

        $this->assertInstanceOf(Pipeline::class, $result);
        $this->assertSame('Updated Pipeline', $result->title);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealGroups/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makePipelines(array $responses): Pipelines
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Pipelines($client);
    }
}
