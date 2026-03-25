<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Tests\Unit\Models;

use ActiveCampaign\Sdk\Models\CustomObjectSchema;
use PHPUnit\Framework\TestCase;

final class CustomObjectSchemaTest extends TestCase
{
    public function testFromArray(): void
    {
        $schema = CustomObjectSchema::fromArray([
            'id' => 'abc-123-uuid',
            'slug' => 'my-object',
            'description' => 'A custom object',
            'labels' => [
                'singular' => 'My Object',
                'plural' => 'My Objects',
            ],
            'visibility' => 'public',
            'createdTimestamp' => '2024-01-01T00:00:00Z',
            'updatedTimestamp' => '2024-01-02T00:00:00Z',
        ]);

        $this->assertSame('abc-123-uuid', $schema->id);
        $this->assertSame('my-object', $schema->slug);
        $this->assertSame('A custom object', $schema->description);
        $this->assertSame('My Object', $schema->singularLabel);
        $this->assertSame('My Objects', $schema->pluralLabel);
        $this->assertSame('public', $schema->visibility);
        $this->assertSame('2024-01-01T00:00:00Z', $schema->createdAt);
        $this->assertSame('2024-01-02T00:00:00Z', $schema->updatedAt);
    }

    public function testFromArrayWithDefaults(): void
    {
        $schema = CustomObjectSchema::fromArray([
            'id' => 'abc-123',
        ]);

        $this->assertSame('abc-123', $schema->id);
        $this->assertSame('', $schema->slug);
        $this->assertSame('', $schema->description);
        $this->assertSame('', $schema->singularLabel);
        $this->assertSame('', $schema->pluralLabel);
        $this->assertSame('private', $schema->visibility);
        $this->assertSame('', $schema->createdAt);
        $this->assertSame('', $schema->updatedAt);
    }
}
