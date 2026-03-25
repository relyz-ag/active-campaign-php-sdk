<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\EcomOrderProduct;
use ActiveCampaign\Sdk\Resources\EcomOrderProducts;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class EcomOrderProductsTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testListEcomOrderProducts(): void
    {
        $products = $this->makeEcomOrderProducts([
            new Response(200, [], (string) json_encode([
                'ecomOrderProducts' => [
                    ['id' => '1', 'orderId' => '10', 'externalid' => 'prod-1', 'name' => 'Widget', 'price' => '2500', 'quantity' => '2', 'category' => 'Gadgets', 'sku' => 'WDG-001', 'description' => 'A widget', 'imageUrl' => 'https://example.com/img.png', 'productUrl' => 'https://example.com/widget', 'createdTimestamp' => '2024-03-15', 'updatedTimestamp' => '2024-03-16'],
                ],
                'meta' => ['total' => '1', 'page_input' => ['limit' => 20, 'offset' => 0]],
            ])),
        ]);

        $result = $products->list();

        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(EcomOrderProduct::class, $result->data[0]);
        $this->assertSame('Widget', $result->data[0]->name);
    }

    public function testGetEcomOrderProduct(): void
    {
        $products = $this->makeEcomOrderProducts([
            new Response(200, [], (string) json_encode([
                'ecomOrderProduct' => ['id' => '1', 'orderId' => '10', 'externalid' => 'prod-1', 'name' => 'Widget', 'price' => '2500', 'quantity' => '2', 'category' => 'Gadgets', 'sku' => 'WDG-001', 'description' => 'A widget', 'imageUrl' => 'https://example.com/img.png', 'productUrl' => 'https://example.com/widget', 'createdTimestamp' => '2024-03-15', 'updatedTimestamp' => '2024-03-16'],
            ])),
        ]);

        $product = $products->get(1);

        $this->assertInstanceOf(EcomOrderProduct::class, $product);
        $this->assertSame(1, $product->id);
        $this->assertSame(10, $product->orderId);
        $this->assertSame('Widget', $product->name);
        $this->assertSame(2500, $product->price);
        $this->assertSame(2, $product->quantity);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeEcomOrderProducts(array $responses): EcomOrderProducts
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new EcomOrderProducts($client);
    }
}
