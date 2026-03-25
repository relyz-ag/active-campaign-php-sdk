<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\DealStage;
use ActiveCampaign\Resources\DealStages;
use GuzzleHttp\Psr7\Response;

final class DealStagesTest extends ResourceTestCase
{
    public function testCreateReturnsDealStageModel(): void
    {
        $stages = $this->makeDealStages([
            new Response(201, [], (string) json_encode([
                'dealStage' => [
                    'id' => '1',
                    'title' => 'To Contact',
                    'group' => '1',
                    'order' => '1',
                    'color' => '32B0FC',
                    'width' => '280',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $stages->create(title: 'To Contact', pipeline: 1, order: 1, color: '32B0FC');

        $this->assertInstanceOf(DealStage::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('To Contact', $result->title);
        $this->assertSame(1, $result->pipeline);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealStages', $this->history[0]['request']->getUri()->getPath());

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(1, $body['dealStage']['group']);
    }

    public function testUpdateReturnsDealStageModel(): void
    {
        $stages = $this->makeDealStages([
            new Response(200, [], (string) json_encode([
                'dealStage' => [
                    'id' => '1',
                    'title' => 'Updated Stage',
                    'group' => '2',
                    'order' => '2',
                    'color' => 'FF0000',
                    'width' => '300',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $stages->update(id: 1, title: 'Updated Stage', pipeline: 2);

        $this->assertInstanceOf(DealStage::class, $result);
        $this->assertSame('Updated Stage', $result->title);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealStages/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealStages(array $responses): DealStages
    {
        return new DealStages($this->makeClient($responses));
    }
}
