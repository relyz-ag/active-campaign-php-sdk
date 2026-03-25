<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Http\Client;

/**
 * @template T
 */
abstract class Resource
{
    public function __construct(
        protected readonly Client $client,
    ) {
    }
}
