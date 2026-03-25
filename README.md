# ActiveCampaign PHP SDK

PHP wrapper for the [ActiveCampaign API v3](https://developers.activecampaign.com/reference). Returns typed models, retries on rate limits, and handles pagination.

**This is an unofficial SDK.** Built and maintained by [relyz AG](https://relyz.ch).

## Requirements

- PHP 8.1+
- Guzzle 7.0+

## Installation

```bash
composer require active-campaign/php-sdk
```

## Usage

```php
$ac = new ActiveCampaign\Sdk\ActiveCampaign(
    url: 'https://youraccountname.api-us1.com',
    apiKey: 'your-api-key',
);
```

Or set the `ACTIVE_CAMPAIGN_API_URL` and `ACTIVE_CAMPAIGN_API_KEY` environment variables (via `.env`, Docker, `export`, etc.) and omit the arguments:

```php
$ac = new ActiveCampaign\Sdk\ActiveCampaign();
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

### List with pagination

```php
$contacts = $ac->contacts()->list(limit: 20, offset: 0);
```

### Error handling

The SDK throws typed exceptions:

- `ActiveCampaignException` — base exception
- `AuthenticationException` — invalid or missing API key
- `NotFoundException` — resource does not exist
- `RateLimitException` — too many requests (retried automatically)
- `ValidationException` — invalid request data

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
