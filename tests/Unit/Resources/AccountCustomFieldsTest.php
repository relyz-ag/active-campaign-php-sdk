<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\AccountCustomField;
use ActiveCampaign\Resources\AccountCustomFields;
use GuzzleHttp\Psr7\Response;

final class AccountCustomFieldsTest extends ResourceTestCase
{
    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'accountCustomFieldMetum' => ['id' => '1', 'fieldLabel' => 'Company Size', 'fieldType' => 'text', 'fieldDefault' => null, 'isFormVisible' => '1', 'displayOrder' => '3', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(fieldLabel: 'Company Size', fieldType: 'text', isFormVisible: true, displayOrder: 3);

        $this->assertInstanceOf(AccountCustomField::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Company Size', $result->fieldLabel);
        $this->assertSame('text', $result->fieldType);
        $this->assertTrue($result->isFormVisible);
        $this->assertSame(3, $result->displayOrder);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountCustomFieldMeta', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'accountCustomFieldMetum' => ['id' => '1', 'fieldLabel' => 'Industry', 'fieldType' => 'dropdown', 'fieldDefault' => 'Tech', 'isFormVisible' => '0', 'displayOrder' => '1', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, fieldLabel: 'Industry', fieldType: 'dropdown', fieldDefault: 'Tech');

        $this->assertInstanceOf(AccountCustomField::class, $result);
        $this->assertSame('Industry', $result->fieldLabel);
        $this->assertSame('dropdown', $result->fieldType);
        $this->assertSame('Tech', $result->fieldDefault);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountCustomFieldMeta/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): AccountCustomFields
    {
        return new AccountCustomFields($this->makeClient($responses));
    }
}
