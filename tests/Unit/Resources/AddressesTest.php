<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Resources\Addresses;
use GuzzleHttp\Psr7\Response;

final class AddressesTest extends ResourceTestCase
{
    public function testDeleteByGroup(): void
    {
        $addresses = $this->makeAddresses([
            new Response(200, [], '{}'),
        ]);

        $addresses->deleteByGroup(groupId: 5);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/addresses/group/5', $this->history[0]['request']->getUri()->getPath());
    }

    public function testDeleteByList(): void
    {
        $addresses = $this->makeAddresses([
            new Response(200, [], '{}'),
        ]);

        $addresses->deleteByList(listId: 3);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/addresses/list/3', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeAddresses(array $responses): Addresses
    {
        return new Addresses($this->makeClient($responses));
    }
}
