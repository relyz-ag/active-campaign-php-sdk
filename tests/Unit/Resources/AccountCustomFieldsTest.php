<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\AccountCustomField;
use ActiveCampaign\Sdk\Resources\AccountCustomFields;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AccountCustomFieldsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

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
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new AccountCustomFields($client);
    }
}
