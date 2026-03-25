<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Http;

use ActiveCampaign\Exceptions\ActiveCampaignException;
use ActiveCampaign\Exceptions\AuthenticationException;
use ActiveCampaign\Exceptions\NotFoundException;
use ActiveCampaign\Exceptions\RateLimitException;
use ActiveCampaign\Exceptions\ValidationException;
use ActiveCampaign\Http\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testGetSendsApiTokenHeader(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"contact":{}}'),
        ]);

        $client->get('contacts/1');

        $this->assertSame('test-api-key', $this->history[0]['request']->getHeaderLine('Api-Token'));
    }

    public function testGetAppendsApiV3Prefix(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"contact":{}}'),
        ]);

        $client->get('contacts/1');

        $this->assertSame('/api/3/contacts/1', $this->history[0]['request']->getUri()->getPath());
    }

    public function testGetReturnsDecodedJson(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"contact":{"id":1,"email":"foo@bar.com"}}'),
        ]);

        $result = $client->get('contacts/1');

        $this->assertSame(['contact' => ['id' => 1, 'email' => 'foo@bar.com']], $result);
    }

    public function testPostSendsJsonBody(): void
    {
        $client = $this->makeClient([
            new Response(201, [], '{"contact":{"id":1}}'),
        ]);

        $client->post('contacts', ['contact' => ['email' => 'foo@bar.com']]);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contact' => ['email' => 'foo@bar.com']], $body);
    }

    public function testPutSendsJsonBody(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"contact":{"id":1}}'),
        ]);

        $client->put('contacts/1', ['contact' => ['firstName' => 'Jane']]);

        $body = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertSame(['contact' => ['firstName' => 'Jane']], $body);
    }

    public function testDeleteSendsRequest(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{}'),
        ]);

        $client->delete('contacts/1');

        $this->assertSame('DELETE', $this->history[0]['request']->getMethod());
    }

    public function testThrowsAuthenticationExceptionOn401(): void
    {
        $client = $this->makeClient([
            new Response(401, [], '{"message":"Unauthorized"}'),
        ]);

        $this->expectException(AuthenticationException::class);
        $client->get('contacts');
    }

    public function testThrowsAuthenticationExceptionOn403(): void
    {
        $client = $this->makeClient([
            new Response(403, [], '{"message":"Forbidden"}'),
        ]);

        $this->expectException(AuthenticationException::class);
        $client->get('contacts');
    }

    public function testThrowsNotFoundExceptionOn404(): void
    {
        $client = $this->makeClient([
            new Response(404, [], '{"message":"Not Found"}'),
        ]);

        $this->expectException(NotFoundException::class);
        $client->get('contacts/999');
    }

    public function testThrowsValidationExceptionOn422(): void
    {
        $client = $this->makeClient([
            new Response(422, [], '{"errors":[{"title":"Invalid"}]}'),
        ]);

        $this->expectException(ValidationException::class);
        $client->post('contacts', ['contact' => []]);
    }

    public function testRetriesOn429ThenSucceeds(): void
    {
        $client = $this->makeClient([
            new Response(429, ['Retry-After' => '0'], ''),
            new Response(200, [], '{"contacts":[]}'),
        ]);

        $result = $client->get('contacts');

        $this->assertSame(['contacts' => []], $result);
        $this->assertCount(2, $this->history);
    }

    public function testThrowsRateLimitExceptionAfterMaxRetries(): void
    {
        $client = $this->makeClient([
            new Response(429, ['Retry-After' => '0'], ''),
            new Response(429, ['Retry-After' => '0'], ''),
            new Response(429, ['Retry-After' => '0'], ''),
            new Response(429, ['Retry-After' => '0'], ''),
        ], maxRetries: 3);

        $this->expectException(RateLimitException::class);
        $client->get('contacts');
    }

    public function testThrowsActiveCampaignExceptionOn500(): void
    {
        $client = $this->makeClient([
            new Response(500, [], '{"message":"Internal Server Error"}'),
        ]);

        $this->expectException(ActiveCampaignException::class);
        $client->get('contacts');
    }

    public function testThrowsActiveCampaignExceptionOn503(): void
    {
        $client = $this->makeClient([
            new Response(503, [], '{"message":"Service Unavailable"}'),
        ]);

        $this->expectException(ActiveCampaignException::class);
        $client->get('contacts');
    }

    public function testGetWithQueryParameters(): void
    {
        $client = $this->makeClient([
            new Response(200, [], '{"contacts":[]}'),
        ]);

        $client->get('contacts', ['limit' => 50, 'offset' => 0]);

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('limit=50', $query);
        $this->assertStringContainsString('offset=0', $query);
    }

    public function testValidationExceptionPreservesApiErrors(): void
    {
        $client = $this->makeClient([
            new Response(422, [], '{"errors":[{"title":"Email is required"}]}'),
        ]);

        try {
            $client->post('contacts', ['contact' => []]);
            $this->fail('Expected ValidationException');
        } catch (ValidationException $e) {
            $this->assertSame(422, $e->getCode());
            $this->assertNotEmpty($e->getResponseBody());
            $this->assertArrayHasKey('errors', $e->getResponseBody());
        }
    }

    public function testServerExceptionPreservesResponseBody(): void
    {
        $client = $this->makeClient([
            new Response(500, [], '{"message":"Internal Server Error"}'),
        ]);

        try {
            $client->get('contacts');
            $this->fail('Expected ActiveCampaignException');
        } catch (ActiveCampaignException $e) {
            $this->assertSame(500, $e->getCode());
            $this->assertSame(['message' => 'Internal Server Error'], $e->getResponseBody());
        }
    }

    public function testCustomRetryDelayCallback(): void
    {
        $delays = [];
        $client = $this->makeClient(
            responses: [
                new Response(429, ['Retry-After' => '2'], ''),
                new Response(200, [], '{"contacts":[]}'),
            ],
            maxRetries: 3,
            retryDelay: function (int $retryAfter, int $attempt) use (&$delays): void {
                $delays[] = ['retryAfter' => $retryAfter, 'attempt' => $attempt];
            },
        );

        $result = $client->get('contacts');

        $this->assertSame(['contacts' => []], $result);
        $this->assertCount(1, $delays);
        $this->assertSame(2, $delays[0]['retryAfter']);
        $this->assertSame(1, $delays[0]['attempt']);
    }

    /**
     * @param list<Response> $responses
     */
    private function makeClient(array $responses, int $maxRetries = 3, ?\Closure $retryDelay = null): Client
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));

        $guzzle = new GuzzleClient([
            'handler' => $stack,
            'base_uri' => 'https://test.api-us1.com',
        ]);

        return new Client(
            url: 'https://test.api-us1.com',
            apiKey: 'test-api-key',
            maxRetries: $maxRetries,
            guzzle: $guzzle,
            retryDelay: $retryDelay,
        );
    }
}
