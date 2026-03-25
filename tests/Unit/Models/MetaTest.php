<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Meta;
use PHPUnit\Framework\TestCase;

final class MetaTest extends TestCase
{
    public function testFromArray(): void
    {
        $meta = Meta::fromArray([
            'total' => '150',
            'page_input' => [
                'limit' => 20,
                'offset' => 0,
            ],
        ]);

        $this->assertSame(150, $meta->total);
        $this->assertSame(20, $meta->limit);
        $this->assertSame(0, $meta->offset);
    }
}
