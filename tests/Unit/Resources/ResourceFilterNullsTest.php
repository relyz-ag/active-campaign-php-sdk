<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;

final class ResourceFilterNullsTest extends TestCase
{
    public function testFilterNullsRemovesNullValues(): void
    {
        $resource = new class () extends \ActiveCampaign\Resources\Resource {
            public function __construct()
            {
            }

            /**
             * @param array<string, mixed> $data
             * @return array<string, mixed>
             */
            public function exposeFilterNulls(array $data): array
            {
                return $this->filterNulls($data);
            }
        };

        $result = $resource->exposeFilterNulls([
            'name' => 'test',
            'email' => null,
            'phone' => '',
            'active' => false,
            'count' => 0,
        ]);

        $this->assertSame(['name' => 'test', 'phone' => '', 'active' => false, 'count' => 0], $result);
    }
}
