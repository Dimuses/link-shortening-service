<?php

declare(strict_types=1);

namespace App\Dto;

use App\Models\ShortLink;
use Illuminate\Support\Carbon;

class ShortLinkDto
{
    public function __construct(
        public string $originalLink,
        public string $shortLink,
        public int $maxVisits,
        public ?Carbon $expiresAt,
        public int $visits = 0,
        public ?int $id = null,
    ) {}

    /**
     * @param ShortLink $shortLink
     * @return static
     */
    public static function fromEloquent(ShortLink $shortLink): self
    {
        return new self(
            originalLink: $shortLink->original_link,
            shortLink: $shortLink->short_link,
            maxVisits: (int)$shortLink->max_visits,
            expiresAt: $shortLink->expires_at ? Carbon::parse($shortLink->expires_at) : null,
            visits: $shortLink->visits,
            id: $shortLink->id
        );
    }

}
