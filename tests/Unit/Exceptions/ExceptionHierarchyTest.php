<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Exceptions;

use ActiveCampaign\Exceptions\ActiveCampaignException;
use ActiveCampaign\Exceptions\AuthenticationException;
use ActiveCampaign\Exceptions\NotFoundException;
use ActiveCampaign\Exceptions\RateLimitException;
use ActiveCampaign\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

final class ExceptionHierarchyTest extends TestCase
{
    public function testAllExceptionsExtendBase(): void
    {
        $this->assertInstanceOf(ActiveCampaignException::class, new AuthenticationException());
        $this->assertInstanceOf(ActiveCampaignException::class, new NotFoundException());
        $this->assertInstanceOf(ActiveCampaignException::class, new ValidationException());
        $this->assertInstanceOf(ActiveCampaignException::class, new RateLimitException());
    }

    public function testBaseExtendsRuntimeException(): void
    {
        $this->assertInstanceOf(\RuntimeException::class, new ActiveCampaignException());
    }
}
