<?php

declare(strict_types=1);

namespace ActiveCampaign\Http;

use ActiveCampaign\Exceptions\ActiveCampaignException;
use ActiveCampaign\Exceptions\AuthenticationException;
use ActiveCampaign\Exceptions\NotFoundException;
use ActiveCampaign\Exceptions\RateLimitException;
use ActiveCampaign\Exceptions\ValidationException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

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
                $body = $this->parseResponseBody($e->getResponse());
                throw new ActiveCampaignException($e->getMessage(), $status, $e, $body);
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

                $body = $this->parseResponseBody($e->getResponse());

                match ($status) {
                    401, 403 => throw new AuthenticationException($e->getMessage(), $status, $e, $body),
                    404 => throw new NotFoundException($e->getMessage(), $status, $e, $body),
                    422 => throw new ValidationException($e->getMessage(), $status, $e, $body),
                    429 => throw new RateLimitException($e->getMessage(), $status, $e, $body),
                    default => throw new ActiveCampaignException($e->getMessage(), $status, $e, $body),
                };
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function parseResponseBody(ResponseInterface $response): array
    {
        try {
            /** @var array<string, mixed> */
            return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return [];
        }
    }
}
