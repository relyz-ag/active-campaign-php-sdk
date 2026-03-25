<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Resources;

use ActiveCampaign\Models\User;
use ActiveCampaign\Resources\Users;
use GuzzleHttp\Psr7\Response;

final class UsersTest extends ResourceTestCase
{
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
        return new Users($this->makeClient($responses));
    }
}
