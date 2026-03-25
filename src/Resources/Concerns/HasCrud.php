<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources\Concerns;

use ActiveCampaign\Http\Paginator;
use ActiveCampaign\Models\ListResponse;
use ActiveCampaign\Models\Meta;

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
     * @return ListResponse<T>
     */
    public function list(array $params = []): ListResponse
    {
        $response = $this->client->get($this->endpoint(), $params);
        $modelClass = $this->modelClass();

        /** @var list<T> $data */
        $data = array_map(
            fn (array $item) => $modelClass::fromArray($item),
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
    public function createRaw(array $data): mixed
    {
        $response = $this->client->post($this->endpoint(), [
            $this->singularKey() => $data,
        ]);
        $modelClass = $this->modelClass();

        return $modelClass::fromArray($response[$this->singularKey()]);
    }

    /**
     * @param array<string, mixed> $data
     * @return T
     */
    public function updateRaw(int $id, array $data): mixed
    {
        $response = $this->client->put($this->endpoint() . '/' . $id, [
            $this->singularKey() => $data,
        ]);
        $modelClass = $this->modelClass();

        return $modelClass::fromArray($response[$this->singularKey()]);
    }

    public function delete(int $id): void
    {
        $this->client->delete($this->endpoint() . '/' . $id);
    }

    /**
     * @param array<string, mixed> $params
     * @return Paginator<T>
     */
    public function paginate(int $limit = 20, array $params = []): Paginator
    {
        return new Paginator(
            client: $this->client,
            endpoint: $this->endpoint(),
            pluralKey: $this->pluralKey(),
            modelClass: $this->modelClass(),
            limit: $limit,
            params: $params,
        );
    }
}
