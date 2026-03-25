<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\DealRole;
use ActiveCampaign\Resources\DealRoles;
use GuzzleHttp\Psr7\Response;

final class DealRolesTest extends ResourceTestCase
{
    public function testCreateReturnsDealRoleModel(): void
    {
        $roles = $this->makeDealRoles([
            new Response(201, [], (string) json_encode([
                'dealRole' => [
                    'id' => '1',
                    'title' => 'Decision Maker',
                    'created_timestamp' => '2024-01-01T00:00:00-05:00',
                    'updated_timestamp' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $roles->create(title: 'Decision Maker');

        $this->assertInstanceOf(DealRole::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Decision Maker', $result->title);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealRoles', $this->history[0]['request']->getUri()->getPath());
    }

    public function testDelete(): void
    {
        $roles = $this->makeDealRoles([
            new Response(200, [], (string) json_encode([])),
        ]);

        $roles->delete(id: 1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealRoles/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealRoles(array $responses): DealRoles
    {
        return new DealRoles($this->makeClient($responses));
    }
}
