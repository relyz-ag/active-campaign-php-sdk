<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\GeoIp;
use PHPUnit\Framework\TestCase;

final class GeoIpTest extends TestCase
{
    public function testFromArray(): void
    {
        $geoIp = GeoIp::fromArray([
            'id' => '1',
            'contact' => '5',
            'campaignid' => '10',
            'messageid' => '3',
            'ip4' => '192.168.1.1',
            'tstamp' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $geoIp->id);
        $this->assertSame(5, $geoIp->contact);
        $this->assertSame('192.168.1.1', $geoIp->ip4);
        $this->assertSame(10, $geoIp->campaignId);
    }
}
