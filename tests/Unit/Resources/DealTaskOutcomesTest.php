<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\DealTaskOutcome;
use ActiveCampaign\Resources\DealTaskOutcomes;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DealTaskOutcomesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateReturnsDealTaskOutcomeModel(): void
    {
        $outcomes = $this->makeDealTaskOutcomes([
            new Response(201, [], (string) json_encode([
                'taskOutcome' => [
                    'id' => '1',
                    'title' => 'Completed',
                    'sentiment' => 'POSITIVE',
                    'disabled' => '0',
                    'created_by' => '1',
                ],
            ])),
        ]);

        $result = $outcomes->create(title: 'Completed', sentiment: 'POSITIVE');

        $this->assertInstanceOf(DealTaskOutcome::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Completed', $result->title);
        $this->assertSame('POSITIVE', $result->sentiment);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/taskOutcomes', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsDealTaskOutcomeModel(): void
    {
        $outcomes = $this->makeDealTaskOutcomes([
            new Response(200, [], (string) json_encode([
                'taskOutcome' => [
                    'id' => '1',
                    'title' => 'Updated Outcome',
                    'sentiment' => 'NEGATIVE',
                    'disabled' => '0',
                    'created_by' => '1',
                ],
            ])),
        ]);

        $result = $outcomes->update(id: 1, title: 'Updated Outcome', sentiment: 'NEGATIVE');

        $this->assertInstanceOf(DealTaskOutcome::class, $result);
        $this->assertSame('Updated Outcome', $result->title);
        $this->assertSame('NEGATIVE', $result->sentiment);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/taskOutcomes/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealTaskOutcomes(array $responses): DealTaskOutcomes
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new DealTaskOutcomes($client);
    }
}
