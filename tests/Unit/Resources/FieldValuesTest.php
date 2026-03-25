<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\FieldValue;
use ActiveCampaign\Resources\FieldValues;
use GuzzleHttp\Psr7\Response;

final class FieldValuesTest extends ResourceTestCase
{
    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'fieldValue' => ['id' => '1', 'contact' => '5', 'field' => '10', 'value' => 'hello', 'cdate' => '2024-01-01', 'udate' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(contact: 5, field: 10, value: 'hello');

        $this->assertInstanceOf(FieldValue::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->contact);
        $this->assertSame(10, $result->field);
        $this->assertSame('hello', $result->value);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldValues', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'fieldValue' => ['id' => '1', 'contact' => '5', 'field' => '10', 'value' => 'updated', 'cdate' => '2024-01-01', 'udate' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, value: 'updated');

        $this->assertInstanceOf(FieldValue::class, $result);
        $this->assertSame('updated', $result->value);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/fieldValues/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): FieldValues
    {
        return new FieldValues($this->makeClient($responses));
    }
}
