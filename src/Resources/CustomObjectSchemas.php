<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources;

use ActiveCampaign\Sdk\Models\CustomObjectSchema;

/**
 * @extends Resource<mixed>
 */
final class CustomObjectSchemas extends Resource
{
    /**
     * @param array<string, mixed> $params
     * @return list<CustomObjectSchema>
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get('customObjects/schemas', $params);

        return array_map(
            fn (array $item) => CustomObjectSchema::fromArray($item),
            $response['schemas'] ?? [],
        );
    }

    public function get(string $id): CustomObjectSchema
    {
        $response = $this->client->get('customObjects/schemas/' . $id);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create_raw(array $data): CustomObjectSchema
    {
        $response = $this->client->post('customObjects/schemas', [
            'schema' => $data,
        ]);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    public function create(
        string $slug,
        string $singularLabel,
        string $pluralLabel,
        ?string $description = null,
    ): CustomObjectSchema {
        return $this->create_raw(array_filter([
            'slug' => $slug,
            'labels' => [
                'singular' => $singularLabel,
                'plural' => $pluralLabel,
            ],
            'description' => $description,
        ], fn ($v) => $v !== null));
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update_raw(string $id, array $data): CustomObjectSchema
    {
        $response = $this->client->put('customObjects/schemas/' . $id, [
            'schema' => $data,
        ]);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    public function update(
        string $id,
        ?string $singularLabel = null,
        ?string $pluralLabel = null,
        ?string $description = null,
    ): CustomObjectSchema {
        $data = array_filter([
            'labels' => array_filter([
                'singular' => $singularLabel,
                'plural' => $pluralLabel,
            ], fn ($v) => $v !== null) ?: null,
            'description' => $description,
        ], fn ($v) => $v !== null);

        return $this->update_raw($id, $data);
    }

    public function delete(string $id): void
    {
        $this->client->delete('customObjects/schemas/' . $id);
    }
}
