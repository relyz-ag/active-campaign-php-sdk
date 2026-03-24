<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Contact;
use ActiveCampaign\Sdk\Models\ListResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class HasCrudTest extends TestCase
{
    public function testListReturnsListResponse(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], json_encode([
                'contacts' => [
                    ['id' => '1', 'email' => 'a@b.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ]) ?: '{}'),
        ]);

        $result = $resource->list();

        $this->assertInstanceOf(ListResponse::class, $result);
        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(Contact::class, $result->data[0]);
        $this->assertSame(1, $result->meta->total);
    }

    public function testGetReturnsSingleModel(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], json_encode([
                'contact' => ['id' => '1', 'email' => 'a@b.com', 'firstName' => 'Jane', 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
            ]) ?: '{}'),
        ]);

        $result = $resource->get(1);

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Jane', $result->firstName);
    }

    public function testCreateReturnsSingleModel(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], json_encode([
                'contact' => ['id' => '3', 'email' => 'new@test.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
            ]) ?: '{}'),
        ]);

        $result = $resource->create(['contact' => ['email' => 'new@test.com']]);

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertSame(3, $result->id);
    }

    public function testUpdateReturnsSingleModel(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], json_encode([
                'contact' => ['id' => '1', 'email' => 'updated@test.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
            ]) ?: '{}'),
        ]);

        $result = $resource->update(1, ['contact' => ['email' => 'updated@test.com']]);

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertSame('updated@test.com', $result->email);
    }

    public function testDeleteReturnsVoid(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], '{}'),
        ]);

        $resource->delete(1);
        $this->addToAssertionCount(1);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): StubResource
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new StubResource($client);
    }
}
