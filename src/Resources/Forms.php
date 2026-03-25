<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Form;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Form>
 */
final class Forms extends Resource
{
    /** @use HasCrud<Form> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'forms';
    }
    protected function singularKey(): string
    {
        return 'form';
    }
    protected function pluralKey(): string
    {
        return 'forms';
    }
    protected function modelClass(): string
    {
        return Form::class;
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function create(string $name, ?string $type = null): Form
    {
        return $this->createRaw($this->filterNulls([
            'name' => $name,
            'type' => $type,
        ]));
    }

    /**
     * @throws \ActiveCampaign\Exceptions\AuthenticationException
     * @throws \ActiveCampaign\Exceptions\NotFoundException
     * @throws \ActiveCampaign\Exceptions\ValidationException
     * @throws \ActiveCampaign\Exceptions\RateLimitException
     * @throws \ActiveCampaign\Exceptions\ActiveCampaignException
     */
    public function update(int $id, ?string $name = null, ?string $type = null): Form
    {
        return $this->updateRaw($id, $this->filterNulls([
            'name' => $name,
            'type' => $type,
        ]));
    }
}
