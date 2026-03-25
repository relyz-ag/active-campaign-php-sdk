<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\BounceLog;
use ActiveCampaign\Models\BulkImportResult;
use ActiveCampaign\Models\BulkImportStatus;
use ActiveCampaign\Models\Contact;
use ActiveCampaign\Models\ContactAutomation;
use ActiveCampaign\Models\ContactDeal;
use ActiveCampaign\Models\ContactList;
use ActiveCampaign\Models\ContactTag;
use ActiveCampaign\Models\EmailActivity;
use ActiveCampaign\Models\GeoIp;
use ActiveCampaign\Models\ScoreValue;
use ActiveCampaign\Models\TrackingLog;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Contact>
 */
final class Contacts extends Resource
{
    /** @use HasCrud<Contact> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'contacts';
    }

    protected function singularKey(): string
    {
        return 'contact';
    }

    protected function pluralKey(): string
    {
        return 'contacts';
    }

    protected function modelClass(): string
    {
        return Contact::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function tag(int $contactId, int $tagId): ContactTag
    {
        $response = $this->client->post('contactTags', [
            'contactTag' => [
                'contact' => $contactId,
                'tag' => $tagId,
            ],
        ]);

        return ContactTag::fromArray($response['contactTag']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function untag(int $contactTagId): void
    {
        $this->client->delete('contactTags/' . $contactTagId);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function addToAutomation(int $contactId, int $automationId): ContactAutomation
    {
        $response = $this->client->post('contactAutomations', [
            'contactAutomation' => [
                'contact' => $contactId,
                'automation' => $automationId,
            ],
        ]);

        return ContactAutomation::fromArray($response['contactAutomation']);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function removeFromAutomation(int $contactAutomationId): void
    {
        $this->client->delete('contactAutomations/' . $contactAutomationId);
    }

    /**
     * @return list<ContactAutomation>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listAutomations(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/contactAutomations');

        return array_map(
            fn (array $item) => ContactAutomation::fromArray($item),
            $response['contactAutomations'] ?? [],
        );
    }

    /**
     * @return list<ContactDeal>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listDeals(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/contactDeals');

        return array_map(
            fn (array $item) => ContactDeal::fromArray($item),
            $response['contactDeals'] ?? [],
        );
    }

    /**
     * @return list<ContactList>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listLists(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/contactLists');

        return array_map(
            fn (array $item) => ContactList::fromArray($item),
            $response['contactLists'] ?? [],
        );
    }

    /**
     * @return list<ScoreValue>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listScoreValues(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/scoreValues');

        return array_map(
            fn (array $item) => ScoreValue::fromArray($item),
            $response['scoreValues'] ?? [],
        );
    }

    /**
     * @return list<GeoIp>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listGeoIps(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/geoIps');

        return array_map(
            fn (array $item) => GeoIp::fromArray($item),
            $response['geoIps'] ?? [],
        );
    }

    /**
     * @return list<BounceLog>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listBounceLogs(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/bounceLogs');

        return array_map(
            fn (array $item) => BounceLog::fromArray($item),
            $response['bounceLogs'] ?? [],
        );
    }

    /**
     * @return list<TrackingLog>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listTrackingLogs(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/trackingLogs');

        return array_map(
            fn (array $item) => TrackingLog::fromArray($item),
            $response['trackingLogs'] ?? [],
        );
    }

    /**
     * @return list<EmailActivity>
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function listEmailActivities(int $contactId): array
    {
        $response = $this->client->get('contacts/' . $contactId . '/emailActivities');

        return array_map(
            fn (array $item) => EmailActivity::fromArray($item),
            $response['emailActivities'] ?? [],
        );
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $email, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): Contact
    {
        return $this->createRaw($this->filterNulls([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $email = null, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): Contact
    {
        return $this->updateRaw($id, $this->filterNulls([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function sync(string $email, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): Contact
    {
        return $this->syncRaw($this->filterNulls([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
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
    public function syncRaw(array $data): Contact
    {
        $response = $this->client->post('contact/sync', [
            'contact' => $data,
        ]);

        return Contact::fromArray($response['contact']);
    }

    /**
     * @param list<array<string, mixed>> $contacts
     *
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function bulkImport(array $contacts, ?string $callback = null): BulkImportResult
    {
        return $this->bulkImportRaw($this->filterNulls([
            'contacts' => $contacts,
            'callback' => $callback,
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
    public function bulkImportRaw(array $data): BulkImportResult
    {
        $response = $this->client->post('import/bulk_import', $data);

        return BulkImportResult::fromArray($response);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function bulkImportStatus(): BulkImportStatus
    {
        $response = $this->client->get('import/info');

        return BulkImportStatus::fromArray($response);
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function updateListStatus(int $contactId, int $listId, int $status): ContactList
    {
        return $this->updateListStatusRaw([
            'list' => $listId,
            'contact' => $contactId,
            'status' => $status,
        ]);
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
    public function updateListStatusRaw(array $data): ContactList
    {
        $response = $this->client->post('contactLists', [
            'contactList' => $data,
        ]);

        return ContactList::fromArray($response['contactList']);
    }
}
