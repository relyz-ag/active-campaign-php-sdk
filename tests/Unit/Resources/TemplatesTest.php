<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Template;
use ActiveCampaign\Sdk\Resources\Templates;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class TemplatesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListTemplates(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'templates' => [
                    ['id' => '1', 'name' => 'Welcome Email', 'subject' => 'Welcome!', 'categoryid' => '5', 'hidden' => '0', 'mdate' => '2024-06-01T00:00:00-05:00'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $resource->list();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/templates', $this->history[0]['request']->getUri()->getPath());
        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(Template::class, $result->data[0]);
        $this->assertSame('Welcome Email', $result->data[0]->name);
    }

    public function testGetTemplate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'template' => [
                    'id' => '1',
                    'name' => 'Welcome Email',
                    'subject' => 'Welcome!',
                    'categoryid' => '5',
                    'hidden' => '0',
                    'mdate' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $template = $resource->get(1);

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/templates/1', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(Template::class, $template);
        $this->assertSame(1, $template->id);
        $this->assertSame('Welcome Email', $template->name);
        $this->assertSame('Welcome!', $template->subject);
        $this->assertSame(5, $template->categoryId);
        $this->assertFalse($template->hidden);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Templates
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Templates($client);
    }
}
