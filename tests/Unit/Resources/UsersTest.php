<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Resources;

use ActiveCampaign\Sdk\Http\Client;
use ActiveCampaign\Sdk\Models\User;
use ActiveCampaign\Sdk\Resources\Users;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class UsersTest extends TestCase
{
    /** @var list<array{request: \GuzzleHttp\Psr7\Request}> */
    private array $history = [];

    public function testGetByEmail(): void
    {
        $users = $this->makeUsers([
            new Response(200, [], (string) json_encode([
                'user' => ['id' => '1', 'username' => 'jane', 'email' => 'jane@test.com', 'firstName' => 'Jane', 'lastName' => null, 'phone' => null, 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-01'],
            ])),
        ]);

        $user = $users->getByEmail('jane@test.com');

        $this->assertInstanceOf(User::class, $user);
        $this->assertStringContainsString('/api/3/users/email/jane%40test.com', $this->history[0]['request']->getUri()->getPath());
    }

    public function testGetByUsername(): void
    {
        $users = $this->makeUsers([
            new Response(200, [], (string) json_encode([
                'user' => ['id' => '1', 'username' => 'jane', 'email' => 'jane@test.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-01'],
            ])),
        ]);

        $user = $users->getByUsername('jane');

        $this->assertInstanceOf(User::class, $user);
        $this->assertStringContainsString('/api/3/users/username/jane', $this->history[0]['request']->getUri()->getPath());
    }

    public function testMe(): void
    {
        $users = $this->makeUsers([
            new Response(200, [], (string) json_encode([
                'user' => ['id' => '1', 'username' => 'me', 'email' => 'me@test.com', 'firstName' => null, 'lastName' => null, 'phone' => null, 'createdTimestamp' => '2024-01-01', 'updatedTimestamp' => '2024-01-01'],
            ])),
        ]);

        $user = $users->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertStringContainsString('/api/3/users/me', $this->history[0]['request']->getUri()->getPath());
    }

    /**
     * @param list<Response> $responses
     */
    private function makeUsers(array $responses): Users
    {
        $this->history = [];
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($this->history));
        $guzzle = new GuzzleClient(['handler' => $stack, 'base_uri' => 'https://test.api-us1.com']);
        $client = new Client(url: 'https://test.api-us1.com', apiKey: 'key', guzzle: $guzzle);

        return new Users($client);
    }
}
