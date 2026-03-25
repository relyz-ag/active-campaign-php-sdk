<?php

declare(strict_types=1);

namespace ActiveCampaign\Http;

use ActiveCampaign\Exceptions\ActiveCampaignException;
use ActiveCampaign\Exceptions\AuthenticationException;
use ActiveCampaign\Exceptions\NotFoundException;
use ActiveCampaign\Exceptions\RateLimitException;
use ActiveCampaign\Exceptions\ValidationException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class Client
{
    private ClientInterface $httpClient;
    private string $baseUri;
    private int $maxRetries;
    /** @var (\Closure(int, int): void)|null */
    private ?\Closure $retryDelay;

    public function __construct(
        string $url,
        private readonly string $apiKey,
        int $maxRetries = 3,
        ?GuzzleClient $guzzle = null,
        ?\Closure $retryDelay = null,
        ?ClientInterface $httpClient = null,
    ) {
        $this->maxRetries = $maxRetries;
        $this->retryDelay = $retryDelay;
        $this->baseUri = rtrim($url, '/');
        $this->httpClient = $httpClient ?? $guzzle ?? new GuzzleClient([
            'base_uri' => $this->baseUri,
        ]);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request('GET', $path, ['query' => $query]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['json' => $data]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request('PUT', $path, ['json' => $data]);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
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
        $uri = $this->baseUri . '/api/3/' . ltrim($path, '/');
        $headers = ['Api-Token' => $this->apiKey];
        $body = null;

        if (isset($options['json'])) {
            $headers['Content-Type'] = 'application/json';
            $body = json_encode($options['json'], JSON_THROW_ON_ERROR);
        }

        if (isset($options['query']) && $options['query'] !== []) {
            $uri .= '?' . http_build_query($options['query']);
        }

        $attempt = 0;

        while (true) {
            $request = new Request($method, $uri, $headers, $body);
            $response = $this->httpClient->sendRequest($request);
            $status = $response->getStatusCode();

            if ($status >= 200 && $status < 300) {
                /** @var array<string, mixed> */
                return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            }

            if ($status === 429 && $attempt < $this->maxRetries) {
                $retryAfter = (int) $response->getHeaderLine('Retry-After');
                $attempt++;
                if ($this->retryDelay !== null) {
                    ($this->retryDelay)($retryAfter, $attempt);
                } elseif ($retryAfter > 0) {
                    sleep($retryAfter);
                }
                continue;
            }

            $responseBody = $this->parseResponseBody($response);

            match ($status) {
                401, 403 => throw new AuthenticationException('Authentication failed', $status, null, $responseBody),
                404 => throw new NotFoundException('Resource not found', $status, null, $responseBody),
                422 => throw new ValidationException('Validation failed', $status, null, $responseBody),
                429 => throw new RateLimitException('Rate limit exceeded', $status, null, $responseBody),
                default => throw new ActiveCampaignException('Request failed with status ' . $status, $status, null, $responseBody),
            };
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
