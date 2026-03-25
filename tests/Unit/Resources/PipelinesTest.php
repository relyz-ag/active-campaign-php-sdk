<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\Pipeline;
use ActiveCampaign\Resources\Pipelines;
use GuzzleHttp\Psr7\Response;

final class PipelinesTest extends ResourceTestCase
{
    public function testCreateReturnsPipelineModel(): void
    {
        $pipelines = $this->makePipelines([
            new Response(201, [], (string) json_encode([
                'dealGroup' => [
                    'id' => '1',
                    'title' => 'Sales Pipeline',
                    'currency' => 'usd',
                    'autoassign' => '1',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-01-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $pipelines->create(title: 'Sales Pipeline', currency: 'usd', autoassign: true);

        $this->assertInstanceOf(Pipeline::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Sales Pipeline', $result->title);
        $this->assertSame('usd', $result->currency);
        $this->assertTrue($result->autoassign);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealGroups', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsPipelineModel(): void
    {
        $pipelines = $this->makePipelines([
            new Response(200, [], (string) json_encode([
                'dealGroup' => [
                    'id' => '1',
                    'title' => 'Updated Pipeline',
                    'currency' => 'eur',
                    'autoassign' => '0',
                    'cdate' => '2024-01-01T00:00:00-05:00',
                    'udate' => '2024-06-01T00:00:00-05:00',
                ],
            ])),
        ]);

        $result = $pipelines->update(id: 1, title: 'Updated Pipeline', currency: 'eur');

        $this->assertInstanceOf(Pipeline::class, $result);
        $this->assertSame('Updated Pipeline', $result->title);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/dealGroups/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makePipelines(array $responses): Pipelines
    {
        return new Pipelines($this->makeClient($responses));
    }
}
