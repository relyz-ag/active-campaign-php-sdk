<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\Contact;
use ActiveCampaign\Sdk\Resources\Contacts;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ContactsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListContacts(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contacts' => [
                    ['id' => '1', 'email' => 'a@b.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $contacts->list();

        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(Contact::class, $result->data[0]);
    }

    public function testGetContact(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contact' => ['id' => '1', 'email' => 'a@b.com', 'firstName' => 'Jane', 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
            ])),
        ]);

        $contact = $contacts->get(1);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame('Jane', $contact->firstName);
    }

    public function testTagContact(): void
    {
        $contacts = $this->makeContacts([
            new Response(201, [], (string) json_encode([
                'contactTag' => ['id' => '10', 'contact' => '1', 'tag' => '5'],
            ])),
        ]);

        $result = $contacts->tag(contactId: 1, tagId: 5);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contactTag' => ['contact' => 1, 'tag' => 5]], $body);
        $this->assertIsArray($result);
    }

    public function testUntagContact(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], '{}'),
        ]);

        $contacts->untag(contactTagId: 10);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('contactTags/10', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeContacts(array $responses): Contacts
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Contacts($client);
    }
}
