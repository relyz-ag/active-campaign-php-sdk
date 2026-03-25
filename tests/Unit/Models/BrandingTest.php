<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\Branding;
use PHPUnit\Framework\TestCase;

final class BrandingTest extends TestCase
{
    public function testFromArray(): void
    {
        $branding = Branding::fromArray([
            'id' => '2',
            'groupid' => '3',
            'siteName' => 'My Site',
            'siteLogo' => 'https://example.com/logo.png',
            'siteLogoSmall' => 'https://example.com/logo-small.png',
            'headerTextValue' => 'Welcome Header',
            'footerTextValue' => 'Footer Text',
        ]);

        $this->assertSame(2, $branding->id);
        $this->assertSame(3, $branding->groupId);
        $this->assertSame('My Site', $branding->siteName);
        $this->assertSame('https://example.com/logo.png', $branding->siteLogo);
        $this->assertSame('https://example.com/logo-small.png', $branding->siteLogoSmall);
        $this->assertSame('Welcome Header', $branding->headerTextValue);
        $this->assertSame('Footer Text', $branding->footerTextValue);
    }

    public function testFromArrayWithDefaults(): void
    {
        $branding = Branding::fromArray([
            'id' => '1',
        ]);

        $this->assertSame(1, $branding->id);
        $this->assertSame(0, $branding->groupId);
        $this->assertSame('', $branding->siteName);
        $this->assertSame('', $branding->siteLogo);
        $this->assertSame('', $branding->siteLogoSmall);
        $this->assertSame('', $branding->headerTextValue);
        $this->assertSame('', $branding->footerTextValue);
    }
}
