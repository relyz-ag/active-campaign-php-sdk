<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\CustomObjectSchema;
use ActiveCampaign\Resources\CustomObjectSchemas;
use GuzzleHttp\Psr7\Response;

final class CustomObjectSchemasTest extends ResourceTestCase
{
    public function testListSchemas(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'schemas' => [
                    [
                        'id' => 'abc-123',
                        'slug' => 'my-object',
                        'description' => 'A custom object',
                        'labels' => ['singular' => 'My Object', 'plural' => 'My Objects'],
                        'visibility' => 'public',
                        'createdTimestamp' => '2024-01-01T00:00:00Z',
                        'updatedTimestamp' => '2024-01-02T00:00:00Z',
                    ],
                ],
            ])),
        ]);

        $result = $resource->list();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/schemas', $this->history[0]['request']->getUri()->getPath());
        $this->assertCount(1, $result);
        $this->assertInstanceOf(CustomObjectSchema::class, $result[0]);
        $this->assertSame('abc-123', $result[0]->id);
    }

    public function testGetSchema(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'schema' => [
                    'id' => 'abc-123',
                    'slug' => 'my-object',
                    'description' => 'A custom object',
                    'labels' => ['singular' => 'My Object', 'plural' => 'My Objects'],
                    'visibility' => 'public',
                    'createdTimestamp' => '2024-01-01T00:00:00Z',
                    'updatedTimestamp' => '2024-01-02T00:00:00Z',
                ],
            ])),
        ]);

        $schema = $resource->get('abc-123');

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/schemas/abc-123', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(CustomObjectSchema::class, $schema);
        $this->assertSame('abc-123', $schema->id);
        $this->assertSame('My Object', $schema->singularLabel);
        $this->assertSame('My Objects', $schema->pluralLabel);
    }

    public function testCreateSchema(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'schema' => [
                    'id' => 'new-123',
                    'slug' => 'my-object',
                    'description' => 'A new object',
                    'labels' => ['singular' => 'My Object', 'plural' => 'My Objects'],
                    'visibility' => 'public',
                    'createdTimestamp' => '2024-01-01T00:00:00Z',
                    'updatedTimestamp' => '2024-01-01T00:00:00Z',
                ],
            ])),
        ]);

        $schema = $resource->create(
            slug: 'my-object',
            singularLabel: 'My Object',
            pluralLabel: 'My Objects',
            description: 'A new object',
        );

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('my-object', $body['schema']['slug']);
        $this->assertSame('My Object', $body['schema']['labels']['singular']);
        $this->assertSame('My Objects', $body['schema']['labels']['plural']);
        $this->assertSame('A new object', $body['schema']['description']);
        $this->assertInstanceOf(CustomObjectSchema::class, $schema);
        $this->assertSame('new-123', $schema->id);
    }

    public function testUpdateSchema(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'schema' => [
                    'id' => 'abc-123',
                    'slug' => 'my-object',
                    'description' => 'Updated description',
                    'labels' => ['singular' => 'Updated Object', 'plural' => 'Updated Objects'],
                    'visibility' => 'public',
                    'createdTimestamp' => '2024-01-01T00:00:00Z',
                    'updatedTimestamp' => '2024-01-03T00:00:00Z',
                ],
            ])),
        ]);

        $schema = $resource->update(
            id: 'abc-123',
            singularLabel: 'Updated Object',
            description: 'Updated description',
        );

        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/schemas/abc-123', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(CustomObjectSchema::class, $schema);
        $this->assertSame('Updated description', $schema->description);
    }

    public function testDeleteSchema(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->delete('abc-123');

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/schemas/abc-123', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): CustomObjectSchemas
    {
        return new CustomObjectSchemas($this->makeClient($responses));
    }
}
