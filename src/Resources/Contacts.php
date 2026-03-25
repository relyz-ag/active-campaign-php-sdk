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
use ActiveCampaign\Models\GeoIp;
use ActiveCampaign\Models\ScoreValue;
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

    public function untag(int $contactTagId): void
    {
        $this->client->delete('contactTags/' . $contactTagId);
    }

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

    public function removeFromAutomation(int $contactAutomationId): void
    {
        $this->client->delete('contactAutomations/' . $contactAutomationId);
    }

    /**
     * @return list<ContactAutomation>
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
     * @return array<string, mixed>
     */
    public function listTrackingLogs(int $contactId): array
    {
        return $this->client->get('contacts/' . $contactId . '/trackingLogs');
    }

    /**
     * @return array<string, mixed>
     */
    public function listEmailActivities(int $contactId): array
    {
        return $this->client->get('contacts/' . $contactId . '/emailActivities');
    }

    public function create(string $email, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): Contact
    {
        return $this->createRaw($this->filterNulls([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

    public function update(int $id, ?string $email = null, ?string $firstName = null, ?string $lastName = null, ?string $phone = null): Contact
    {
        return $this->updateRaw($id, $this->filterNulls([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phone' => $phone,
        ]));
    }

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
     */
    public function bulkImportRaw(array $data): BulkImportResult
    {
        $response = $this->client->post('import/bulk_import', $data);

        return BulkImportResult::fromArray($response);
    }

    public function bulkImportStatus(): BulkImportStatus
    {
        $response = $this->client->get('import/info');

        return BulkImportStatus::fromArray($response);
    }

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
     */
    public function updateListStatusRaw(array $data): ContactList
    {
        $response = $this->client->post('contactLists', [
            'contactList' => $data,
        ]);

        return ContactList::fromArray($response['contactList']);
    }
}
