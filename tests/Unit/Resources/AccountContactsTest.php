<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\AccountContact;
use ActiveCampaign\Resources\AccountContacts;
use GuzzleHttp\Psr7\Response;

final class AccountContactsTest extends ResourceTestCase
{
    public function testCreate(): void
    {
        $resource = $this->make([
            new Response(201, [], (string) json_encode([
                'accountContact' => ['id' => '1', 'account' => '5', 'contact' => '10', 'jobTitle' => 'Engineer', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-02'],
            ])),
        ]);

        $result = $resource->create(account: 5, contact: 10, jobTitle: 'Engineer');

        $this->assertInstanceOf(AccountContact::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame(5, $result->account);
        $this->assertSame(10, $result->contact);
        $this->assertSame('Engineer', $result->jobTitle);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountContacts', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdate(): void
    {
        $resource = $this->make([
            new Response(200, [], (string) json_encode([
                'accountContact' => ['id' => '1', 'account' => '5', 'contact' => '10', 'jobTitle' => 'Manager', 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-03'],
            ])),
        ]);

        $result = $resource->update(id: 1, jobTitle: 'Manager');

        $this->assertInstanceOf(AccountContact::class, $result);
        $this->assertSame('Manager', $result->jobTitle);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/accountContacts/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function make(array $responses): AccountContacts
    {
        return new AccountContacts($this->makeClient($responses));
    }
}
