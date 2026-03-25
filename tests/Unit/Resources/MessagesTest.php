<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\Message;
use ActiveCampaign\Resources\Messages;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class MessagesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'message' => [
                    'id' => '1',
                    'subject' => 'Welcome',
                    'fromname' => 'John',
                    'fromemail' => 'john@example.com',
                    'reply2' => '',
                    'preheader_text' => null,
                    'html' => '<p>Hello</p>',
                    'text' => null,
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(subject: 'Welcome', fromName: 'John', fromEmail: 'john@example.com', html: '<p>Hello</p>');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Welcome', $result->subject);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/messages', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('john@example.com', $body['message']['fromemail']);
        $this->assertSame('John', $body['message']['fromname']);
    }

    public function testUpdate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'message' => [
                    'id' => '1',
                    'subject' => 'Updated Subject',
                    'fromname' => 'John',
                    'fromemail' => 'john@example.com',
                    'reply2' => '',
                    'preheader_text' => 'New preview',
                    'html' => null,
                    'text' => null,
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-02',
                ],
            ])),
        ]);

        $result = $resource->update(id: 1, subject: 'Updated Subject', preheaderText: 'New preview');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame('Updated Subject', $result->subject);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/messages/1', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Updated Subject', $body['message']['subject']);
        $this->assertSame('New preview', $body['message']['preheader_text']);
        $this->assertArrayNotHasKey('fromname', $body['message']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Messages
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Messages($client);
    }
}
