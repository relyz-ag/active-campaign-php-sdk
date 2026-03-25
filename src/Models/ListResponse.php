<?php

declare(strict_types=1);

namespace ActiveCampaign\Models;

/**
 * @template T
 */
final class ListResponse
{
    /**
     * @param list<T> $data
     */
    public function __construct(
        public readonly array $data,
        public readonly Meta $meta,
    ) {
    }
}
