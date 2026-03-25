<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\EcomOrder;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<EcomOrder>
 */
final class EcomOrders extends Resource
{
    /** @use HasCrud<EcomOrder> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'ecomOrders';
    }

    protected function singularKey(): string
    {
        return 'ecomOrder';
    }

    protected function pluralKey(): string
    {
        return 'ecomOrders';
    }

    protected function modelClass(): string
    {
        return EcomOrder::class;
    }

    public function create(
        int $connectionId,
        int $customerId,
        string $externalId,
        string $email,
        int $totalPrice,
        string $currency,
        string $orderDate,
        ?string $orderNumber = null,
        ?string $shippingMethod = null,
        ?int $state = null,
    ): EcomOrder {
        return $this->create_raw(array_filter([
            'connectionid' => $connectionId,
            'customerid' => $customerId,
            'externalid' => $externalId,
            'email' => $email,
            'totalPrice' => $totalPrice,
            'currency' => $currency,
            'orderDate' => $orderDate,
            'orderNumber' => $orderNumber,
            'shippingMethod' => $shippingMethod,
        ], fn ($v) => $v !== null));
    }

    public function update(
        int $id,
        ?string $externalId = null,
        ?string $email = null,
        ?int $totalPrice = null,
        ?string $currency = null,
        ?string $orderDate = null,
        ?string $orderNumber = null,
        ?string $shippingMethod = null,
        ?int $state = null,
    ): EcomOrder {
        return $this->update_raw($id, array_filter([
            'externalid' => $externalId,
            'email' => $email,
            'totalPrice' => $totalPrice,
            'currency' => $currency,
            'orderDate' => $orderDate,
            'orderNumber' => $orderNumber,
            'shippingMethod' => $shippingMethod,
            'state' => $state,
        ], fn ($v) => $v !== null));
    }
}
