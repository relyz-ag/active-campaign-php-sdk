<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Template;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    public function testFromArray(): void
    {
        $template = Template::fromArray([
            'id' => '42',
            'name' => 'Welcome Email',
            'subject' => 'Welcome!',
            'categoryid' => '5',
            'hidden' => '1',
            'mdate' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(42, $template->id);
        $this->assertSame('Welcome Email', $template->name);
        $this->assertSame('Welcome!', $template->subject);
        $this->assertSame(5, $template->categoryId);
        $this->assertTrue($template->hidden);
        $this->assertSame('2024-06-01T00:00:00-05:00', $template->updatedAt);
    }

    public function testFromArrayWithNullableFields(): void
    {
        $template = Template::fromArray([
            'id' => '1',
            'name' => 'Basic Template',
            'mdate' => '2024-01-01T00:00:00-05:00',
        ]);

        $this->assertSame(1, $template->id);
        $this->assertSame('Basic Template', $template->name);
        $this->assertNull($template->subject);
        $this->assertNull($template->categoryId);
        $this->assertFalse($template->hidden);
        $this->assertSame('2024-01-01T00:00:00-05:00', $template->updatedAt);
    }
}
