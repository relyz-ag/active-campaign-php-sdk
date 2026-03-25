<?php

declare(strict_types=1);

namespace ActiveCampaign\Tests\Unit\Models;

use ActiveCampaign\Models\Form;
use PHPUnit\Framework\TestCase;

final class FormTest extends TestCase
{
    public function testFromArray(): void
    {
        $form = Form::fromArray([
            'id' => '4',
            'name' => 'Newsletter Signup',
            'formType' => 'inline',
            'createdTimestamp' => '2024-01-01T00:00:00-05:00',
            'updatedTimestamp' => '2024-06-01T00:00:00-05:00',
        ]);

        $this->assertSame(4, $form->id);
        $this->assertSame('Newsletter Signup', $form->name);
        $this->assertSame('inline', $form->type);
        $this->assertSame('2024-01-01T00:00:00-05:00', $form->createdAt);
        $this->assertSame('2024-06-01T00:00:00-05:00', $form->updatedAt);
    }
}
