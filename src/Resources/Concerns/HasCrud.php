<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Resources\Concerns;

use ActiveCampaign\Sdk\Models\ListResponse;
use ActiveCampaign\Sdk\Models\Meta;

/**
 * @template T
 */
trait HasCrud
{
    abstract protected function endpoint(): string;
    abstract protected function singularKey(): string;
    abstract protected function pluralKey(): string;

    /**
     * @return class-string<T>
     */
    abstract protected function modelClass(): string;

    /**
     * @param array<string, mixed> $params
     */
    public function list(array $params = []): ListResponse
    {
        $response = $this->client->get($this->endpoint(), $params);
        $modelClass = $this->modelClass();

        $data = array_map(
            fn (array $item): mixed => $modelClass::fromArray($item),
            $response[$this->pluralKey()] ?? [],
        );

        $meta = Meta::fromArray($response['meta'] ?? []);

        return new ListResponse(data: $data, meta: $meta);
    }

    /**
     * @return T
     */
    public function get(int $id): mixed
    {
        $response = $this->client->get($this->endpoint() . '/' . $id);
        $modelClass = $this->modelClass();

        return $modelClass::fromArray($response[$this->singularKey()]);
    }

    /**
     * @param array<string, mixed> $data
     * @return T
     */
    public function create(array $data): mixed
    {
        $response = $this->client->post($this->endpoint(), $data);
        $modelClass = $this->modelClass();

        return $modelClass::fromArray($response[$this->singularKey()]);
    }

    /**
     * @param array<string, mixed> $data
     * @return T
     */
    public function update(int $id, array $data): mixed
    {
        $response = $this->client->put($this->endpoint() . '/' . $id, $data);
        $modelClass = $this->modelClass();

        return $modelClass::fromArray($response[$this->singularKey()]);
    }

    public function delete(int $id): void
    {
        $this->client->delete($this->endpoint() . '/' . $id);
    }
}
