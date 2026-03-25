<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\DealTaskOutcome;
use ActiveCampaign\Resources\DealTaskOutcomes;
use GuzzleHttp\Psr7\Response;

final class DealTaskOutcomesTest extends ResourceTestCase
{
    public function testCreateReturnsDealTaskOutcomeModel(): void
    {
        $outcomes = $this->makeDealTaskOutcomes([
            new Response(201, [], (string) json_encode([
                'taskOutcome' => [
                    'id' => '1',
                    'title' => 'Completed',
                    'sentiment' => 'POSITIVE',
                    'disabled' => '0',
                    'created_by' => '1',
                ],
            ])),
        ]);

        $result = $outcomes->create(title: 'Completed', sentiment: 'POSITIVE');

        $this->assertInstanceOf(DealTaskOutcome::class, $result);
        $this->assertSame(1, $result->id);
        $this->assertSame('Completed', $result->title);
        $this->assertSame('POSITIVE', $result->sentiment);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/taskOutcomes', $this->history[0]['request']->getUri()->getPath());
    }

    public function testUpdateReturnsDealTaskOutcomeModel(): void
    {
        $outcomes = $this->makeDealTaskOutcomes([
            new Response(200, [], (string) json_encode([
                'taskOutcome' => [
                    'id' => '1',
                    'title' => 'Updated Outcome',
                    'sentiment' => 'NEGATIVE',
                    'disabled' => '0',
                    'created_by' => '1',
                ],
            ])),
        ]);

        $result = $outcomes->update(id: 1, title: 'Updated Outcome', sentiment: 'NEGATIVE');

        $this->assertInstanceOf(DealTaskOutcome::class, $result);
        $this->assertSame('Updated Outcome', $result->title);
        $this->assertSame('NEGATIVE', $result->sentiment);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/taskOutcomes/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeDealTaskOutcomes(array $responses): DealTaskOutcomes
    {
        return new DealTaskOutcomes($this->makeClient($responses));
    }
}
