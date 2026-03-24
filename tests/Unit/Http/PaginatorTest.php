<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Http;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Http\Paginator;
use ActiveCampaign\Sdk\Models\Contact;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PaginatorTest extends TestCase
{
    public function testIteratesAcrossMultiplePages(): void
    {
        $client = $this->makeClient([
            new Response(200, [], (string) json_encode([
                'contacts' => [
                    ['id' => '1', 'email' => 'a@b.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
                    ['id' => '2', 'email' => 'c@d.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
                ],
                'meta' => ['total' => '3', 'page_input' => ['limit' => 2, 'offset' => 0]],
            ])),
            new Response(200, [], (string) json_encode([
                'contacts' => [
                    ['id' => '3', 'email' => 'e@f.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
                ],
                'meta' => ['total' => '3', 'page_input' => ['limit' => 2, 'offset' => 2]],
            ])),
        ]);

        $paginator = new Paginator(
            client: $client,
            endpoint: 'contacts',
            pluralKey: 'contacts',
            modelClass: Contact::class,
            limit: 2,
        );

        $results = iterator_to_array($paginator);

        $this->assertCount(3, $results);
        $this->assertInstanceOf(Contact::class, $results[0]);
        $this->assertSame(1, $results[0]->id);
        $this->assertSame(3, $results[2]->id);
    }

    public function testStopsWhenNoMoreResults(): void
    {
        $client = $this->makeClient([
            new Response(200, [], (string) json_encode([
                'contacts' => [],
                'meta' => ['total' => '0', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $paginator = new Paginator(
            client: $client,
            endpoint: 'contacts',
            pluralKey: 'contacts',
            modelClass: Contact::class,
        );

        $results = iterator_to_array($paginator);

        $this->assertCount(0, $results);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeClient(array $responses): Client
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);

        return new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);
    }
}
