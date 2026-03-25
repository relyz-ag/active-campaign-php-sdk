<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Group;
use ActiveCampaign\Resources\Groups;
use GuzzleHttp\Psr7\Response;

final class GroupsTest extends ResourceTestCase
{
    public function testCreate(): void
    {
        $resource = $this->makeResource([
            new Response(201, [], (string) json_encode([
                'group' => [
                    'id' => '1',
                    'title' => 'Editors',
                    'descript' => 'Editor group',
                    'p_admin' => '0',
                    'cdate' => '2024-01-01',
                    'udate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->create(title: 'Editors', description: 'Editor group');

        $this->assertInstanceOf(Group::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Editors', $result->title);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/groups', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Editor group', $body['group']['descript']);
    }

    public function testUpdate(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'group' => [
                    'id' => '1',
                    'title' => 'Updated Editors',
                    'descript' => 'Editor group',
                    'p_admin' => '0',
                    'cdate' => '2024-01-01',
                    'udate' => '2024-01-02',
                ],
            ])),
        ]);

        $result = $resource->update(id: 1, title: 'Updated Editors');

        $this->assertInstanceOf(Group::class, $result);
        $this->assertSame('Updated Editors', $result->title);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/groups/1', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('Updated Editors', $body['group']['title']);
        $this->assertArrayNotHasKey('descript', $body['group']);
    }

    public function testListLimits(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'limits' => ['users' => 10, 'lists' => 50],
            ])),
        ]);

        $result = $resource->listLimits();

        $this->assertIsArray($result);
        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/groups/limits', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Groups
    {
        return new Groups($this->makeClient($responses));
    }
}
