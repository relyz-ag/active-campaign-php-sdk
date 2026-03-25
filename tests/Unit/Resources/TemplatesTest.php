<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Template;
use ActiveCampaign\Resources\Templates;
use GuzzleHttp\Psr7\Response;

final class TemplatesTest extends ResourceTestCase
{
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
        return new Templates($this->makeClient($responses));
    }
}
