<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\SavedResponse;
use ActiveCampaign\Resources\SavedResponses;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SavedResponsesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'savedResponse' => [
                    'id' => '1',
                    'title' => 'Follow Up',
                    'subject' => 'Re: Your inquiry',
                    'body' => 'Thank you for reaching out.',
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(title: 'Follow Up', subject: 'Re: Your inquiry', body: 'Thank you for reaching out.');

        $this->assertInstanceOf(SavedResponse::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Follow Up', $result->title);
        $this->assertSame('Re: Your inquiry', $result->subject);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/savedResponses', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'savedResponse' => [
                    'id' => '1',
                    'title' => 'Updated Follow Up',
                    'subject' => 'Re: Your inquiry',
                    'body' => 'Updated body.',
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-02',
                ],
            ])),
        ]);

        $result = $resource->update(id: 1, title: 'Updated Follow Up', body: 'Updated body.');

        $this->assertInstanceOf(SavedResponse::class, $result);
        $this->assertSame('Updated Follow Up', $result->title);
        $this->assertSame('Updated body.', $result->body);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/savedResponses/1', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Updated Follow Up', $body['savedResponse']['title']);
        $this->assertSame('Updated body.', $body['savedResponse']['body']);
        $this->assertArrayNotHasKey('subject', $body['savedResponse']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): SavedResponses
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new SavedResponses($client);
    }
}
