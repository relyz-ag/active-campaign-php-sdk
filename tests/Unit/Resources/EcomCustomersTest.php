<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\EcomCustomer;
use ActiveCampaign\Sdk\Resources\EcomCustomers;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class EcomCustomersTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListEcomCustomers(): void
    {
        $customers = $this->makeEcomCustomers([
            new Response(200, [], (string) json_encode([
                'ecomCustomers' => [
                    ['id' => '1', 'connectionid' => '2', 'externalid' => 'cust-1', 'email' => 'a@b.com', 'totalRevenue' => '5000', 'totalOrders' => '2', 'totalProducts' => '5', 'acceptsMarketing' => '1', 'tstamp' => '2024-01-01'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $customers->list();

        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(EcomCustomer::class, $result->data[0]);
        $this->assertSame('a@b.com', $result->data[0]->email);
    }

    public function testGetEcomCustomer(): void
    {
        $customers = $this->makeEcomCustomers([
            new Response(200, [], (string) json_encode([
                'ecomCustomer' => ['id' => '1', 'connectionid' => '2', 'externalid' => 'cust-1', 'email' => 'a@b.com', 'totalRevenue' => '5000', 'totalOrders' => '2', 'totalProducts' => '5', 'acceptsMarketing' => '1', 'tstamp' => '2024-01-01'],
            ])),
        ]);

        $customer = $customers->get(1);

        $this->assertInstanceOf(EcomCustomer::class, $customer);
        $this->assertSame(1, $customer->id);
    }

    public function testCreateEcomCustomer(): void
    {
        $customers = $this->makeEcomCustomers([
            new Response(201, [], (string) json_encode([
                'ecomCustomer' => ['id' => '1', 'connectionid' => '2', 'externalid' => 'cust-1', 'email' => 'a@b.com', 'totalRevenue' => '0', 'totalOrders' => '0', 'totalProducts' => '0', 'acceptsMarketing' => '1', 'tstamp' => '2024-01-01'],
            ])),
        ]);

        $customer = $customers->create(connectionId: 2, externalId: 'cust-1', email: 'a@b.com', acceptsMarketing: true);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('POST', $this->history[0]['request']->getMethod());
        $this->assertSame(2, $body['ecomCustomer']['connectionid']);
        $this->assertSame('cust-1', $body['ecomCustomer']['externalid']);
        $this->assertSame('a@b.com', $body['ecomCustomer']['email']);
        $this->assertTrue($body['ecomCustomer']['acceptsMarketing']);
        $this->assertInstanceOf(EcomCustomer::class, $customer);
    }

    public function testUpdateEcomCustomer(): void
    {
        $customers = $this->makeEcomCustomers([
            new Response(200, [], (string) json_encode([
                'ecomCustomer' => ['id' => '1', 'connectionid' => '2', 'externalid' => 'cust-1', 'email' => 'new@b.com', 'totalRevenue' => '5000', 'totalOrders' => '2', 'totalProducts' => '5', 'acceptsMarketing' => '0', 'tstamp' => '2024-01-01'],
            ])),
        ]);

        $customer = $customers->update(id: 1, email: 'new@b.com');

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame('PUT', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/ecomCustomers/1', $this->history[0]['request']->getUri()->getPath());
        $this->assertSame('new@b.com', $body['ecomCustomer']['email']);
        $this->assertSame('new@b.com', $customer->email);
    }

    public function testDeleteEcomCustomer(): void
    {
        $customers = $this->makeEcomCustomers([
            new Response(200, [], '{}'),
        ]);

        $customers->delete(1);

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
        $this->assertStringContainsString('/api/3/ecomCustomers/1', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeEcomCustomers(array $responses): EcomCustomers
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new EcomCustomers($client);
    }
}
