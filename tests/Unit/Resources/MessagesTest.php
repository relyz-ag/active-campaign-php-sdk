<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Message;
use ActiveCampaign\Resources\Messages;
use GuzzleHttp\Psr7\Response;

final class MessagesTest extends ResourceTestCase
{
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
        return new Messages($this->makeClient($responses));
    }
}
