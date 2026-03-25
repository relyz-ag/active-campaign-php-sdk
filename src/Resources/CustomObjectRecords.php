<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Http\Client;
use ActiveCampaign\Models\CustomObjectRecord;

/**
 * @extends Resource<mixed>
 */
final class CustomObjectRecords extends Resource
{
    public function __construct(
        Client $client,
        private readonly string $schemaId,
    ) {
        parent::__construct($client);
    }

    /**
     * @param array<string, mixed> $params
     * @return list<CustomObjectRecord>
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get('customObjects/records/' . $this->schemaId, $params);

        return array_map(
            fn (array $item) => CustomObjectRecord::fromArray($item),
            $response['records'] ?? [],
        );
    }

    public function get(string $id): CustomObjectRecord
    {
        $response = $this->client->get('customObjects/records/' . $this->schemaId . '/' . $id);

        return CustomObjectRecord::fromArray($response['record']);
    }

    /**
     * @param array<string, mixed> $fields
     * @param array<string, mixed>|null $relationships
     */
    public function create(array $fields, ?string $externalId = null, ?array $relationships = null): CustomObjectRecord
    {
        $data = $this->filterNulls([
            'record' => $this->filterNulls([
                'fields' => $fields,
                'externalId' => $externalId,
                'relationships' => $relationships,
            ]),
        ]);

        $response = $this->client->post('customObjects/records/' . $this->schemaId, $data);

        return CustomObjectRecord::fromArray($response['record']);
    }

    public function delete(string $id): void
    {
        $this->client->delete('customObjects/records/' . $this->schemaId . '/' . $id);
    }

    public function getByExternalId(string $externalId): CustomObjectRecord
    {
        $response = $this->client->get('customObjects/records/' . $this->schemaId . '/external/' . $externalId);

        return CustomObjectRecord::fromArray($response['record']);
    }
}
