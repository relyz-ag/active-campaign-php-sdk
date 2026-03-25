<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\CustomObjectRecord;
use ActiveCampaign\Resources\CustomObjectRecords;
use GuzzleHttp\Psr7\Response;

final class CustomObjectRecordsTest extends ResourceTestCase
{
    private string $schemaId = 'schema-uuid-123';

    public function testListRecords(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'records' => [
                    [
                        'id' => 'rec-001',
                        'externalId' => 'ext-1',
                        'schemaId' => $this->schemaId,
                        'fields' => ['name' => 'Test'],
                        'relationships' => [],
                    ],
                ],
            ])),
        ]);

        $result = $resource->list();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/records/' . $this->schemaId, $this->history[0]['request']->getUri()->getPath());
        $this->assertCount(1, $result);
        $this->assertInstanceOf(CustomObjectRecord::class, $result[0]);
        $this->assertSame('rec-001', $result[0]->id);
    }

    public function testGetRecord(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'record' => [
                    'id' => 'rec-001',
                    'externalId' => 'ext-1',
                    'schemaId' => $this->schemaId,
                    'fields' => ['name' => 'Test'],
                    'relationships' => [],
                ],
            ])),
        ]);

        $record = $resource->get('rec-001');

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/records/' . $this->schemaId . '/rec-001', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(CustomObjectRecord::class, $record);
        $this->assertSame('rec-001', $record->id);
        $this->assertSame('ext-1', $record->externalId);
    }

    public function testCreateRecord(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'record' => [
                    'id' => 'rec-002',
                    'externalId' => 'ext-2',
                    'schemaId' => $this->schemaId,
                    'fields' => ['name' => 'New Record'],
                    'relationships' => [],
                ],
            ])),
        ]);

        $record = $resource->create(
            fields: ['name' => 'New Record'],
            externalId: 'ext-2',
        );

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/records/' . $this->schemaId, $this->history[0]['request']->getUri()->getPath());
        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('New Record', $body['record']['fields']['name']);
        $this->assertSame('ext-2', $body['record']['externalId']);
        $this->assertInstanceOf(CustomObjectRecord::class, $record);
        $this->assertSame('rec-002', $record->id);
    }

    public function testDeleteRecord(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->delete('rec-001');

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/records/' . $this->schemaId . '/rec-001', $this->history[0]['request']->getUri()->getPath());
    }

    public function testGetByExternalId(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'record' => [
                    'id' => 'rec-001',
                    'externalId' => 'ext-1',
                    'schemaId' => $this->schemaId,
                    'fields' => ['name' => 'Test'],
                    'relationships' => [],
                ],
            ])),
        ]);

        $record = $resource->getByExternalId('ext-1');

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/customObjects/records/' . $this->schemaId . '/external/ext-1', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(CustomObjectRecord::class, $record);
        $this->assertSame('ext-1', $record->externalId);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): CustomObjectRecords
    {
        return new CustomObjectRecords($this->makeClient($responses), $this->schemaId);
    }
}
