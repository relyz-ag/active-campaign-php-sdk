<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\AccountCustomFieldValue;
use ActiveCampaign\Sdk\Resources\AccountCustomFieldValues;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AccountCustomFieldValuesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'accountCustomFieldDatum' => ['id' => '1', 'accountId' => '5', 'accountCustomFieldMetumId' => '10', 'fieldValue' => 'hello', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(accountId: 5, customFieldId: 10, fieldValue: 'hello');

        $this->assertInstanceOf(AccountCustomFieldValue::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->accountId);
        $this->assertSame(10, $result->customFieldId);
        $this->assertSame('hello', $result->fieldValue);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountCustomFieldData', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'accountCustomFieldDatum' => ['id' => '1', 'accountId' => '5', 'accountCustomFieldMetumId' => '10', 'fieldValue' => 'updated', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, fieldValue: 'updated');

        $this->assertInstanceOf(AccountCustomFieldValue::class, $result);
        $this->assertSame('updated', $result->fieldValue);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountCustomFieldData/1', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'accountCustomFieldData' => [
                    ['id' => '1', 'accountId' => '5', 'accountCustomFieldMetumId' => '10', 'fieldValue' => 'a', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-01'],
                    ['id' => '2', 'accountId' => '5', 'accountCustomFieldMetumId' => '11', 'fieldValue' => 'b', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-01'],
                ],
            ])),
        ]);

        $result = $resource->bulkCreate([
            ['accountId' => 5, 'accountCustomFieldMetumId' => 10, 'fieldValue' => 'a'],
            ['accountId' => 5, 'accountCustomFieldMetumId' => 11, 'fieldValue' => 'b'],
        ]);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(AccountCustomFieldValue::class, $result[0]);
        $this->assertInstanceOf(AccountCustomFieldValue::class, $result[1]);
        $this->assertSame('a', $result[0]->fieldValue);
        $this->assertSame('b', $result[1]->fieldValue);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountCustomFieldData/bulkCreate', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): AccountCustomFieldValues
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new AccountCustomFieldValues($client);
    }
}
