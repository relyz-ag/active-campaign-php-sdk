<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Exceptions;

use ActiveCampaign\Sdk\Exceptions\ActiveCampaignException;
use ActiveCampaign\Sdk\Exceptions\AuthenticationException;
use ActiveCampaign\Sdk\Exceptions\NotFoundException;
use ActiveCampaign\Sdk\Exceptions\RateLimitException;
use ActiveCampaign\Sdk\Exceptions\ValidationException;
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
