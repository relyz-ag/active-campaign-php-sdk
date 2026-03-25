# ActiveCampaign PHP SDK

PHP wrapper for the [ActiveCampaign API v3](https://developers.activecampaign.com/reference). Returns typed models, retries on rate limits, and handles pagination.

**This is an unofficial SDK.** Built and maintained by [relyz AG](https://relyz.ch).

> **Note:** This SDK targets ActiveCampaign API v3 exclusively. The API version prefix (`/api/3/`) is not configurable.

## Requirements

- PHP 8.1+
- Guzzle 7.0+

## Installation

```bash
composer require active-campaign/php-sdk
```

## Usage

```php
$ac = new ActiveCampaign\Client(
    url: 'https://youraccountname.api-us1.com',
    apiKey: 'your-api-key',
);
```

Or set the `ACTIVE_CAMPAIGN_API_URL` and `ACTIVE_CAMPAIGN_API_KEY` environment variables (via `.env`, Docker, `export`, etc.) and omit the arguments:

```php
$ac = new ActiveCampaign\Client();
```

### Create a contact

```php
$contact = $ac->contacts()->create([
    'email' => 'jane@example.com',
    'firstName' => 'Jane',
    'lastName' => 'Doe',
]);

// $contact is a typed Contact model
echo $contact->id;
```

## Error Handling

The SDK throws typed exceptions for different HTTP error scenarios:

```php
use ActiveCampaign\Exceptions\AuthenticationException;
use ActiveCampaign\Exceptions\NotFoundException;
use ActiveCampaign\Exceptions\ValidationException;
use ActiveCampaign\Exceptions\RateLimitException;
use ActiveCampaign\Exceptions\ActiveCampaignException;

try {
    $contact = $ac->contacts()->get(999);
} catch (NotFoundException $e) {
    // 404 — resource not found
    echo $e->getMessage();
    print_r($e->getResponseBody()); // parsed JSON from API
} catch (ValidationException $e) {
    // 422 — validation failed
    print_r($e->getResponseBody()['errors'] ?? []);
} catch (AuthenticationException $e) {
    // 401/403 — invalid or missing API key
} catch (RateLimitException $e) {
    // 429 — rate limit exceeded (after retries exhausted)
} catch (ActiveCampaignException $e) {
    // All other API errors (5xx, etc.)
}
```

All exceptions extend `ActiveCampaignException`, which extends `RuntimeException`. Every exception provides `getResponseBody()` returning the parsed API response as an array.

## Pagination

### Basic Listing

```php
$result = $ac->contacts()->list(['limit' => 50, 'offset' => 0]);

foreach ($result->data as $contact) {
    echo $contact->email;
}

echo $result->meta->total;  // Total records available
```

### Lazy Pagination

Use `paginate()` for automatic lazy-loading across all pages:

```php
foreach ($ac->contacts()->paginate(limit: 100) as $contact) {
    echo $contact->email; // Fetches next page automatically
}
```

## Rate Limiting

The SDK automatically retries requests that receive a `429 Too Many Requests` response, respecting the `Retry-After` header. By default, it retries up to 3 times using `sleep()`.

To customize retry behavior (e.g., for non-blocking strategies or logging):

```php
$ac = new Client(
    url: 'https://yourinstance.api-us1.com',
    apiKey: 'your-api-key',
    maxRetries: 5,
);
```

For advanced control, provide a custom retry callback via the HTTP client:

```php
use ActiveCampaign\Http\Client as HttpClient;

$httpClient = new HttpClient(
    url: 'https://yourinstance.api-us1.com',
    apiKey: 'your-api-key',
    retryDelay: function (int $retryAfter, int $attempt): void {
        // Custom logic: log, use non-blocking sleep, etc.
        usleep($retryAfter * 1_000_000);
    },
);
```

## Custom HTTP Client

The SDK accepts any PSR-18 compatible HTTP client:

```php
use ActiveCampaign\Client;

$ac = new Client(
    url: 'https://yourinstance.api-us1.com',
    apiKey: 'your-api-key',
    httpClient: $yourPsr18Client,
);
```

By default, the SDK uses Guzzle 7.

## Environment Variables

The SDK reads these environment variables as fallbacks when constructor arguments are not provided:

| Variable | Description |
|----------|-------------|
| `ACTIVE_CAMPAIGN_API_URL` | Your ActiveCampaign API URL |
| `ACTIVE_CAMPAIGN_API_KEY` | Your ActiveCampaign API key |

```php
// Uses environment variables automatically
$ac = new Client();
```

## Available Resources

Each resource is a method on the client object.

**Core:** `contacts()`, `deals()`, `tags()`, `lists()`, `accounts()`, `automations()`, `campaigns()`, `webhooks()`, `customFields()`, `notes()`, `forms()`, `segments()`, `users()`, `addresses()`

**Deals:** `pipelines()`, `dealStages()`, `dealCustomFields()`, `dealCustomFieldValues()`, `dealRoles()`, `dealTasks()`, `dealTaskTypes()`, `dealTaskOutcomes()`

**Accounts:** `accountContacts()`, `accountCustomFields()`, `accountCustomFieldValues()`

**Contact fields:** `fieldValues()`, `fieldOptions()`

**Communication:** `messages()`, `scores()`

**Admin:** `groups()`, `calendarFeeds()`, `brandings()`, `savedResponses()`, `templates()`, `settings()`

**E-Commerce:** `connections()`, `ecomCustomers()`, `ecomOrders()`, `ecomOrderProducts()`

**Tracking:** `eventTracking()`, `siteTracking()`

**Custom Objects:** `customObjectSchemas()`, `customObjectRecords($schemaId)`

## Bugs

Report issues at [GitHub Issues](https://github.com/relyz-ag/active-campaign-php-sdk/issues).

## License

MIT
