<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\BounceLog;
use ActiveCampaign\Sdk\Models\BulkImportResult;
use ActiveCampaign\Sdk\Models\BulkImportStatus;
use ActiveCampaign\Sdk\Models\Contact;
use ActiveCampaign\Sdk\Models\ContactAutomation;
use ActiveCampaign\Sdk\Models\ContactDeal;
use ActiveCampaign\Sdk\Models\ContactList;
use ActiveCampaign\Sdk\Models\ContactTag;
use ActiveCampaign\Sdk\Models\GeoIp;
use ActiveCampaign\Sdk\Models\ScoreValue;
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
                'contactTag' => ['id' => '10', 'contact' => '1', 'tag' => '5', 'cdate' => '2024-01-01T00:00:00-05:00'],
            ])),
        ]);

        $result = $contacts->tag(contactId: 1, tagId: 5);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contactTag' => ['contact' => 1, 'tag' => 5]], $body);
        $this->assertInstanceOf(ContactTag::class, $result);
        $this->assertSame(1, $result->contact);
        $this->assertSame(5, $result->tag);
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
                'contactAutomations' => [['id' => '1', 'contact' => '10', 'automation' => '2', 'status' => '1', 'completed' => 0, 'completeValue' => 0, 'adddate' => '2024-01-01', 'remdate' => null]],
            ])),
        ]);

        $result = $contacts->listAutomations(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(ContactAutomation::class, $result[0]);
        $this->assertSame(2, $result[0]->automation);
    }

    public function testListDeals(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contactDeals' => [['id' => '1', 'deal' => '5', 'contact' => '1', 'role' => '0', 'cdate' => '2024-01-01']],
            ])),
        ]);

        $result = $contacts->listDeals(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(ContactDeal::class, $result[0]);
        $this->assertSame(5, $result[0]->deal);
    }

    public function testListLists(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contactLists' => [['id' => '1', 'contact' => '1', 'list' => '3', 'status' => '1', 'sdate' => '2024-01-01', 'udate' => '2024-01-01']],
            ])),
        ]);

        $result = $contacts->listLists(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(ContactList::class, $result[0]);
        $this->assertSame(3, $result[0]->list);
    }

    public function testListScoreValues(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'scoreValues' => [['id' => '1', 'score' => '2', 'contact' => '1', 'deal' => null, 'scoreValue' => '85', 'cdate' => '2024-01-01', 'mdate' => '2024-01-01']],
            ])),
        ]);

        $result = $contacts->listScoreValues(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(ScoreValue::class, $result[0]);
        $this->assertSame(85, $result[0]->scoreValue);
    }

    public function testListGeoIps(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'geoIps' => [['id' => '1', 'contact' => '1', 'campaignid' => '5', 'messageid' => '3', 'ip4' => '127.0.0.1', 'tstamp' => '2024-01-01']],
            ])),
        ]);

        $result = $contacts->listGeoIps(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(GeoIp::class, $result[0]);
        $this->assertSame('127.0.0.1', $result[0]->ip4);
    }

    public function testListBounceLogs(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'bounceLogs' => [['id' => '1', 'contact' => '1', 'email' => 'a@b.com', 'error' => 'mailbox full', 'source' => 'smtp', 'tstamp' => '2024-01-01']],
            ])),
        ]);

        $result = $contacts->listBounceLogs(1);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(BounceLog::class, $result[0]);
        $this->assertSame('mailbox full', $result[0]->error);
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
                'contactAutomation' => ['id' => '1', 'contact' => '1', 'automation' => '2', 'status' => 1, 'completed' => 0, 'completeValue' => 50, 'adddate' => '2024-01-01', 'remdate' => null],
            ])),
        ]);

        $result = $contacts->addToAutomation(contactId: 1, automationId: 2);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contactAutomation' => ['contact' => 1, 'automation' => 2]], $body);
        $this->assertInstanceOf(ContactAutomation::class, $result);
        $this->assertSame(2, $result->automation);
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

        $contact = $contacts->sync(email: 'a@b.com', firstName: 'Jane');

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/contact/sync', $this->history[0]['request']->getUri()->getPath());
    }

    public function testBulkImport(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'Success' => 1,
                'queued_contacts' => 1,
                'batchId' => 'abc-123',
                'message' => 'Import queued',
            ])),
        ]);

        $result = $contacts->bulkImport(contacts: [['email' => 'a@b.com']]);

        $this->assertInstanceOf(BulkImportResult::class, $result);
        $this->assertTrue($result->success);
        $this->assertSame('abc-123', $result->batchId);
        $this->assertSame(1, $result->queuedContacts);
    }

    public function testBulkImportStatus(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'status' => 'completed',
                'success' => ['123', '124'],
                'failure' => ['bad@invalid'],
            ])),
        ]);

        $result = $contacts->bulkImportStatus();

        $this->assertInstanceOf(BulkImportStatus::class, $result);
        $this->assertSame('completed', $result->status);
        $this->assertCount(2, $result->successIds);
        $this->assertCount(1, $result->failedEmails);
    }

    public function testUpdateListStatus(): void
    {
        $contacts = $this->makeContacts([
            new Response(200, [], (string) json_encode([
                'contacts' => [],
                'contactList' => ['id' => '1', 'contact' => '1', 'list' => '2', 'status' => '1', 'sdate' => '2024-01-01', 'udate' => '2024-01-01'],
            ])),
        ]);

        $result = $contacts->updateListStatus(contactId: 1, listId: 1, status: 1);

        $this->assertInstanceOf(ContactList::class, $result);
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
