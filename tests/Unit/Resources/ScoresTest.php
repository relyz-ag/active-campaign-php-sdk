<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Score;
use ActiveCampaign\Resources\Scores;
use GuzzleHttp\Psr7\Response;

final class ScoresTest extends ResourceTestCase
{
    public function testGet(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'score' => [
                    'id' => '3',
                    'name' => 'Lead Score',
                    'reltype' => 'contact',
                    'descript' => 'Scores contacts',
                    'status' => '1',
                    'cdate' => '2024-01-01',
                    'mdate' => '2024-01-01',
                ],
            ])),
        ]);

        $result = $resource->get(3);

        $this->assertInstanceOf(Score::class, $result);
        $this->assertSame(3, $result->id);
        $this->assertSame('Lead Score', $result->name);
        $this->assertSame('contact', $result->relType);
        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/scores/3', $this->history[0]['request']->getUri()->getPath());
    }

    public function testList(): void
    {
        $resource = $this->makeResource([
            new Response(200, [], (string) json_encode([
                'scores' => [
                    [
                        'id' => '1',
                        'name' => 'Score A',
                        'reltype' => 'contact',
                        'descript' => 'First score',
                        'status' => '1',
                        'cdate' => '2024-01-01',
                        'mdate' => '2024-01-01',
                    ],
                    [
                        'id' => '2',
                        'name' => 'Score B',
                        'reltype' => 'deal',
                        'descript' => 'Second score',
                        'status' => '0',
                        'cdate' => '2024-01-01',
                        'mdate' => '2024-01-01',
                    ],
                ],
                'meta' => ['total' => '2'],
            ])),
        ]);

        $result = $resource->list();

        $this->assertCount(2, $result->data);
        $this->assertSame('Score A', $result->data[0]->name);
        $this->assertSame('Score B', $result->data[1]->name);
        $this->assertSame('GET', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/scores', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeResource(array $responses): Scores
    {
        return new Scores($this->makeClient($responses));
    }
}
