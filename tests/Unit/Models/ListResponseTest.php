<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\ListResponse;
use ActiveCampaign\Sdk\Models\Meta;
use PHPUnit\Framework\TestCase;

final class ListResponseTest extends TestCase
{
    public function testHoldsDataAndMeta(): void
    {
        $meta = Meta::fromArray([
            'total' => '2',
            'page_input' => ['limit' => 20, 'offset' => 0],
        ]);

        $response = new ListResponse(
            data: ['item1', 'item2'],
            meta: $meta,
        );

        $this->assertSame(['item1', 'item2'], $response->data);
        $this->assertSame(2, $response->meta->total);
    }
}
