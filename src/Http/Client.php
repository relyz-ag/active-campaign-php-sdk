<?php

declare(strict_types=1);

namespace ActiveCampaign\Sdk\Http;

use ActiveCampaign\Sdk\Exceptions\ActiveCampaignException;
use ActiveCampaign\Sdk\Exceptions\AuthenticationException;
use ActiveCampaign\Sdk\Exceptions\NotFoundException;
use ActiveCampaign\Sdk\Exceptions\RateLimitException;
use ActiveCampaign\Sdk\Exceptions\ValidationException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

final class Client
{
    private GuzzleClient $guzzle;
    private int $maxRetries;

    public function __construct(
        string $url,
        private readonly string $apiKey,
        int $maxRetries = 3,
        ?GuzzleClient $guzzle = null,
    ) {
        $this->maxRetries = $maxRetries;
        $this->guzzle = $guzzle ?? new GuzzleClient([
            'base_uri' => rtrim($url, '/'),
        ]);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['json' => $data]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request('PUT', $path, ['json' => $data]);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    public function delete(string $path, array $query = []): array
    {
        return $this->request('DELETE', $path, $query ? ['query' => $query] : []);
    }

    /**
     * @param array<string, mixed> $options
     * @return array<string, mixed>
     */
    private function request(string $method, string $path, array $options = []): array
    {
        $options['headers']['Api-Token'] = $this->apiKey;
        $uri = '/api/3/' . ltrim($path, '/');

        $attempt = 0;

        while (true) {
            try {
                $response = $this->guzzle->request($method, $uri, $options);

                /** @var array<string, mixed> */
                return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            } catch (ServerException $e) {
                $status = $e->getResponse()->getStatusCode();
                throw new ActiveCampaignException($e->getMessage(), $status, $e);
            } catch (ClientException $e) {
                $status = $e->getResponse()->getStatusCode();

                if ($status === 429 && $attempt < $this->maxRetries) {
                    $retryAfter = (int) $e->getResponse()->getHeaderLine('Retry-After');
                    if ($retryAfter > 0) {
                        sleep($retryAfter);
                    }
                    $attempt++;
                    continue;
                }

                match ($status) {
                    401, 403 => throw new AuthenticationException($e->getMessage(), $status, $e),
                    404 => throw new NotFoundException($e->getMessage(), $status, $e),
                    422 => throw new ValidationException($e->getMessage(), $status, $e),
                    429 => throw new RateLimitException($e->getMessage(), $status, $e),
                    default => throw new ActiveCampaignException($e->getMessage(), $status, $e),
                };
            }
        }
    }
}
