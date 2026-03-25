<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\SiteTrackingDomain;
use PHPUnit\Framework\TestCase;

final class SiteTrackingDomainTest extends TestCase
{
    public function testFromArray(): void
    {
        $domain = SiteTrackingDomain::fromArray(['name' => 'example.com']);

        $this->assertSame('example.com', $domain->name);
    }
}
