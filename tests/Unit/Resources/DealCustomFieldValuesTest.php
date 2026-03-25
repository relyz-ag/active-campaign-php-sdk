<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\DealCustomFieldValue;
use ActiveCampaign\Sdk\Resources\DealCustomFieldValues;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DealCustomFieldValuesTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testCreateReturnsDealCustomFieldValueModel(): void
    {
        $values = $this->makeDealCustomFieldValues([
            new Response(201, [], (string) json_encode([
                'dealCustomFieldDatum' => [
                    'id' => '1',
                    'dealId' => '5',
                    'customFieldId' => '3',
                    'fieldValue' => '1000',
                    'fieldCurrency' => 'usd',
                    'createdTimestamp' => '2024-01-01T00:00:00-05:00',
                    'updatedTimestamp' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $values->create(dealId: 5, customFieldId: 3, fieldValue: '1000', fieldCurrency: 'usd');

        $this->assertInstanceOf(DealCustomFieldValue::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->dealId);
        $this->assertSame(3, $result->customFieldId);
        $this->assertSame('1000', $result->fieldValue);
        $this->assertSame('usd', $result->fieldCurrency);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealCustomFieldData', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsDealCustomFieldValueModel(): void
    {
        $values = $this->makeDealCustomFieldValues([
            new Response(200, [], (string) json_encode([
                'dealCustomFieldDatum' => [
                    'id' => '1',
                    'dealId' => '5',
                    'customFieldId' => '3',
                    'fieldValue' => '2000',
                    'fieldCurrency' => 'eur',
                    'createdTimestamp' => '2024-01-01T00:00:00-05:00',
                    'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $values->update(id: 1, fieldValue: '2000', fieldCurrency: 'eur');

        $this->assertInstanceOf(DealCustomFieldValue::class, $result);
        $this->assertSame('2000', $result->fieldValue);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealCustomFieldData/1', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkCreate(): void
    {
        $values = $this->makeDealCustomFieldValues([
            new Response(200, [], (string) json_encode([
                'message' => 'bulk created',
            ])),
        ]);

        $result = $values->bulkCreate([
            ['dealId' => 1, 'customFieldId' => 1, 'fieldValue' => 'test'],
        ]);

        $this->assertSame('bulk created', $result['message']);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealCustomFieldData/bulkCreate', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealCustomFieldValues(array $responses): DealCustomFieldValues
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new DealCustomFieldValues($client);
    }
}
