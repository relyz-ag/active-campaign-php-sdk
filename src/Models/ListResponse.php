<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Models;

final class ListResponse
{
    /**
     * @param list<mixed> $data
     */
    public function __construct(
        public readonly array $data,
        public readonly Meta $meta,
    ) {
    }
}
