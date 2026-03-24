<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Http\Client;

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
