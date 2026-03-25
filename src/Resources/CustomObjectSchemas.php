<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\CustomObjectSchema;

/**
 * @extends Resource<mixed>
 */
final class CustomObjectSchemas extends Resource
{
    /**
     * @param array<string, mixed> $params
     * @return list<CustomObjectSchema>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get('customObjects/schemas', $params);

        return array_map(
            fn (array $item) => CustomObjectSchema::fromArray($item),
            $response['schemas'] ?? [],
        );
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function get(string $id): CustomObjectSchema
    {
        $response = $this->client->get('customObjects/schemas/' . $id);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function createRaw(array $data): CustomObjectSchema
    {
        $response = $this->client->post('customObjects/schemas', [
            'schema' => $data,
        ]);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(
        string $slug,
        string $singularLabel,
        string $pluralLabel,
        ?string $description = null,
    ): CustomObjectSchema {
        return $this->createRaw($this->filterNulls([
            'slug' => $slug,
            'labels' => [
                'singular' => $singularLabel,
                'plural' => $pluralLabel,
            ],
            'description' => $description,
        ]));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function updateRaw(string $id, array $data): CustomObjectSchema
    {
        $response = $this->client->put('customObjects/schemas/' . $id, [
            'schema' => $data,
        ]);

        return CustomObjectSchema::fromArray($response['schema']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(
        string $id,
        ?string $singularLabel = null,
        ?string $pluralLabel = null,
        ?string $description = null,
    ): CustomObjectSchema {
        $data = $this->filterNulls([
            'labels' => $this->filterNulls([
                'singular' => $singularLabel,
                'plural' => $pluralLabel,
            ]) ?: null,
            'description' => $description,
        ]);

        return $this->updateRaw($id, $data);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function delete(string $id): void
    {
        $this->client->delete('customObjects/schemas/' . $id);
    }
}
