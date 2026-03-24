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

    public function testListAutomations(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contactAutomations' => [['id' => '1']],
            ])),
        ]);

        $result = $contacts->listAutomations(1);

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/contacts/1/contactAutomations', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    public function testListDeals(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'deals' => [['id' => '1']],
            ])),
        ]);

        $result = $contacts->listDeals(1);

        $this->assertStringContainsString('/api/3/contacts/1/contactDeals', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListLists(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contactLists' => [],
            ])),
        ]);

        $result = $contacts->listLists(1);

        $this->assertStringContainsString('/api/3/contacts/1/contactLists', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListScoreValues(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'scoreValues' => [],
            ])),
        ]);

        $result = $contacts->listScoreValues(1);

        $this->assertStringContainsString('/api/3/contacts/1/scoreValues', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListGeoIps(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'geoIps' => [],
            ])),
        ]);

        $result = $contacts->listGeoIps(1);

        $this->assertStringContainsString('/api/3/contacts/1/geoIps', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListBounceLogs(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'bounceLogs' => [],
            ])),
        ]);

        $result = $contacts->listBounceLogs(1);

        $this->assertStringContainsString('/api/3/contacts/1/bounceLogs', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListTrackingLogs(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'trackingLogs' => [],
            ])),
        ]);

        $result = $contacts->listTrackingLogs(1);

        $this->assertStringContainsString('/api/3/contacts/1/trackingLogs', $this->history[0]['request']->getUri()->getPath());
    }

    public function testListEmailActivities(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'emailActivities' => [],
            ])),
        ]);

        $result = $contacts->listEmailActivities(1);

        $this->assertStringContainsString('/api/3/contacts/1/emailActivities', $this->history[0]['request']->getUri()->getPath());
    }

    public function testAddToAutomation(): void
    {
        $contacts = $this->makeContacts([
            new Response(201, [], (string) json_encode([
                'contactAutomation' => ['id' => '1', 'contact' => '1', 'automation' => '2'],
            ])),
        ]);

        $result = $contacts->addToAutomation(contactId: 1, automationId: 2);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contactAutomation' => ['contact' => 1, 'automation' => 2]], $body);
        $this->assertStringContainsString('/api/3/contactAutomations', $this->history[0]['request']->getUri()->getPath());
    }

    public function testRemoveFromAutomation(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], '{}'),
        ]);

        $contacts->removeFromAutomation(contactAutomationId: 5);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/contactAutomations/5', $this->history[0]['request']->getUri()->getPath());
    }

    public function testSyncContact(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contact' => ['id' => '1', 'email' => 'a@b.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'cdate' => '2024-01-01T00:00:00-05:00', 'udate' => '2024-01-01T00:00:00-05:00'],
            ])),
        ]);

        $contact = $contacts->sync(['email' => 'a@b.com', 'firstName' => 'Jane']);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/contact/sync', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkImport(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'message' => 'Import queued',
                'batchId' => 'abc-123',
            ])),
        ]);

        $result = $contacts->bulkImport([
            'contacts' => [['email' => 'a@b.com']],
        ]);

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/import/bulk_import', $this->history[0]['request']->getUri()->getPath());
        $this->assertIsArray($result);
    }

    public function testBulkImportStatus(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'status' => 'completed',
            ])),
        ]);

        $result = $contacts->bulkImportStatus();

        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/import/info', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateListStatus(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contacts' => [],
            ])),
        ]);

        $result = $contacts->updateListStatus([
            'list' => 1,
            'contact' => 1,
            'status' => 1,
        ]);

        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/contactLists', $this->history[0]['request']->getUri()->getPath());
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
