<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Enums;

use ActiveCampaign\Enums\DealStatus;
use PHPUnit\Framework\TestCase;

final class DealStatusTest extends TestCase
{
    public function testValues(): void
    {
        $this->assertSame(0, DealStatus::Open->value);
        $this->assertSame(1, DealStatus::Won->value);
        $this->assertSame(2, DealStatus::Lost->value);
    }

    public function testFromInt(): void
    {
        $this->assertSame(DealStatus::Won, DealStatus::from(1));
    }
}
