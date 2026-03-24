<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Http;

/**
 * @template T
 * @implements \IteratorAggregate<int, T>
 */
final class Paginator implements \IteratorAggregate
{
    /**
     * @param class-string<T> $modelClass
     * @param array<string, mixed> $params
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $endpoint,
        private readonly string $pluralKey,
        private readonly string $modelClass,
        private readonly int $limit = 20,
        private readonly array $params = [],
    ) {
    }

    /**
     * @return \Generator<int, T>
     */
    public function getIterator(): \Generator
    {
        $offset = 0;

        while (true) {
            $response = $this->client->get($this->endpoint, array_merge(
                $this->params,
                ['limit' => $this->limit, 'offset' => $offset],
            ));

            $items = $response[$this->pluralKey] ?? [];

            if ($items === []) {
                return;
            }

            $modelClass = $this->modelClass;
            foreach ($items as $item) {
                yield $modelClass::fromArray($item);
            }

            $total = (int) ($response['meta']['total'] ?? 0);
            $offset += $this->limit;

            if ($offset >= $total) {
                return;
            }
        }
    }
}
