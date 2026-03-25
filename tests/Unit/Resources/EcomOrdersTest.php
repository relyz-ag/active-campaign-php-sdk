<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\EcomOrder;
use ActiveCampaign\Resources\EcomOrders;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class EcomOrdersTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListEcomOrders(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(200, [], (string) json_encode([
                'ecomOrders' => [
                    ['id' => '1', 'connectionid' => '2', 'customerid' => '3', 'externalid' => 'ord-1', 'email' => 'a@b.com', 'totalPrice' => '9999', 'currency' => 'USD', 'orderNumber' => 'ORD-001', 'orderDate' => '2024-03-15', 'shippingMethod' => 'UPS', 'state' => '1', 'createdDate' => '2024-03-15', 'updatedDate' => '2024-03-16'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $orders->list();

        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(EcomOrder::class, $result->data[0]);
        $this->assertSame('USD', $result->data[0]->currency);
    }

    public function testGetEcomOrder(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(200, [], (string) json_encode([
                'ecomOrder' => ['id' => '1', 'connectionid' => '2', 'customerid' => '3', 'externalid' => 'ord-1', 'email' => 'a@b.com', 'totalPrice' => '9999', 'currency' => 'USD', 'orderNumber' => 'ORD-001', 'orderDate' => '2024-03-15', 'shippingMethod' => 'UPS', 'state' => '1', 'createdDate' => '2024-03-15', 'updatedDate' => '2024-03-16'],
            ])),
        ]);

        $order = $orders->get(1);

        $this->assertInstanceOf(EcomOrder::class, $order);
        $this->assertSame(1, $order->id);
    }

    public function testCreateEcomOrder(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(201, [], (string) json_encode([
                'ecomOrder' => ['id' => '1', 'connectionid' => '2', 'customerid' => '3', 'externalid' => 'ord-1', 'email' => 'a@b.com', 'totalPrice' => '9999', 'currency' => 'USD', 'orderNumber' => 'ORD-001', 'orderDate' => '2024-03-15', 'shippingMethod' => 'UPS', 'state' => '1', 'createdDate' => '2024-03-15', 'updatedDate' => '2024-03-16'],
            ])),
        ]);

        $order = $orders->create(
            connectionId: 2,
            customerId: 3,
            externalId: 'ord-1',
            email: 'a@b.com',
            totalPrice: 9999,
            currency: 'USD',
            orderDate: '2024-03-15',
            orderNumber: 'ORD-001',
            shippingMethod: 'UPS',
        );

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertSame(2, $body['ecomOrder']['connectionid']);
        $this->assertSame(3, $body['ecomOrder']['customerid']);
        $this->assertSame('ord-1', $body['ecomOrder']['externalid']);
        $this->assertSame('a@b.com', $body['ecomOrder']['email']);
        $this->assertSame(9999, $body['ecomOrder']['totalPrice']);
        $this->assertSame('USD', $body['ecomOrder']['currency']);
        $this->assertSame('2024-03-15', $body['ecomOrder']['orderDate']);
        $this->assertSame('ORD-001', $body['ecomOrder']['orderNumber']);
        $this->assertSame('UPS', $body['ecomOrder']['shippingMethod']);
        $this->assertInstanceOf(EcomOrder::class, $order);
    }

    public function testCreateEcomOrderWithoutOptionalFields(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(201, [], (string) json_encode([
                'ecomOrder' => ['id' => '1', 'connectionid' => '2', 'customerid' => '3', 'externalid' => 'ord-1', 'email' => 'a@b.com', 'totalPrice' => '9999', 'currency' => 'USD', 'orderDate' => '2024-03-15', 'state' => '0', 'createdDate' => '2024-03-15', 'updatedDate' => ''],
            ])),
        ]);

        $order = $orders->create(
            connectionId: 2,
            customerId: 3,
            externalId: 'ord-1',
            email: 'a@b.com',
            totalPrice: 9999,
            currency: 'USD',
            orderDate: '2024-03-15',
        );

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertArrayNotHasKey('orderNumber', $body['ecomOrder']);
        $this->assertArrayNotHasKey('shippingMethod', $body['ecomOrder']);
        $this->assertInstanceOf(EcomOrder::class, $order);
    }

    public function testUpdateEcomOrder(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(200, [], (string) json_encode([
                'ecomOrder' => ['id' => '1', 'connectionid' => '2', 'customerid' => '3', 'externalid' => 'ord-1', 'email' => 'new@b.com', 'totalPrice' => '5000', 'currency' => 'USD', 'orderDate' => '2024-03-15', 'state' => '2', 'createdDate' => '2024-03-15', 'updatedDate' => '2024-03-17'],
            ])),
        ]);

        $order = $orders->update(id: 1, email: 'new@b.com', totalPrice: 5000, state: 2);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/ecomOrders/1', $this->history[0]['request']->getUri()->getPath());
        $this->assertSame('new@b.com', $body['ecomOrder']['email']);
        $this->assertSame(5000, $body['ecomOrder']['totalPrice']);
        $this->assertSame(2, $body['ecomOrder']['state']);
        $this->assertSame('new@b.com', $order->email);
    }

    public function testDeleteEcomOrder(): void
    {
        $orders = $this->makeEcomOrders([
            new Response(200, [], '{}'),
        ]);

        $orders->delete(1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/ecomOrders/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeEcomOrders(array $responses): EcomOrders
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new EcomOrders($client);
    }
}
