<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\EcomOrderProduct;
use ActiveCampaign\Sdk\Resources\Concerns\HasCrud;

/**
 * @extends Resource<EcomOrderProduct>
 */
final class EcomOrderProducts extends Resource
{
    /** @use HasCrud<EcomOrderProduct> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'ecomOrderProducts';
    }

    protected function singularKey(): string
    {
        return 'ecomOrderProduct';
    }

    protected function pluralKey(): string
    {
        return 'ecomOrderProducts';
    }

    protected function modelClass(): string
    {
        return EcomOrderProduct::class;
    }
}
