<?php

declare(strict_types=1);

namespace ActiveCampaign\Resources;

use ActiveCampaign\Models\Branding;
use ActiveCampaign\Resources\Concerns\HasCrud;

/**
 * @extends Resource<Branding>
 */
final class Brandings extends Resource
{
    /** @use HasCrud<Branding> */
    use HasCrud;

    protected function endpoint(): string
    {
        return 'brandings';
    }

    protected function singularKey(): string
    {
        return 'branding';
    }

    protected function pluralKey(): string
    {
        return 'brandings';
    }

    protected function modelClass(): string
    {
        return Branding::class;
    }

    public function update(int $id, ?string $siteName = null, ?string $siteLogo = null, ?string $siteLogoSmall = null, ?string $headerTextValue = null, ?string $footerTextValue = null): Branding
    {
        return $this->update_raw($id, array_filter([
            'siteName' => $siteName,
            'siteLogo' => $siteLogo,
            'siteLogoSmall' => $siteLogoSmall,
            'headerTextValue' => $headerTextValue,
            'footerTextValue' => $footerTextValue,
        ], fn ($v) => $v !== null));
    }
}
