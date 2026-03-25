<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\DealCustomField;
use ActiveCampaign\Resources\DealCustomFields;
use GuzzleHttp\Psr7\Response;

final class DealCustomFieldsTest extends ResourceTestCase
{
    public function testCreateReturnsDealCustomFieldModel(): void
    {
        $fields = $this->makeDealCustomFields([
            new Response(201, [], (string) json_encode([
                'dealCustomFieldMetum' => [
                    'id' => '1',
                    'fieldLabel' => 'Revenue',
                    'fieldType' => 'currency',
                    'fieldDefault' => '0',
                    'isFormVisible' => '1',
                    'isRequired' => '0',
                    'displayOrder' => '1',
                    'createdTimestamp' => '2024-01-01T00:00:00-05:00',
                    'updatedTimestamp' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $fields->create(fieldLabel: 'Revenue', fieldType: 'currency', fieldDefault: '0');

        $this->assertInstanceOf(DealCustomField::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Revenue', $result->fieldLabel);
        $this->assertSame('currency', $result->fieldType);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealCustomFieldMeta', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsDealCustomFieldModel(): void
    {
        $fields = $this->makeDealCustomFields([
            new Response(200, [], (string) json_encode([
                'dealCustomFieldMetum' => [
                    'id' => '1',
                    'fieldLabel' => 'Updated Field',
                    'fieldType' => 'text',
                    'fieldDefault' => null,
                    'isFormVisible' => '0',
                    'isRequired' => '0',
                    'displayOrder' => '2',
                    'createdTimestamp' => '2024-01-01T00:00:00-05:00',
                    'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $fields->update(id: 1, fieldLabel: 'Updated Field');

        $this->assertInstanceOf(DealCustomField::class, $result);
        $this->assertSame('Updated Field', $result->fieldLabel);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealCustomFieldMeta/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealCustomFields(array $responses): DealCustomFields
    {
        return new DealCustomFields($this->makeClient($responses));
    }
}
