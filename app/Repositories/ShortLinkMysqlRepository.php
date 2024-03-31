<?php

namespace App\Repositories;

use App\Dto\ShortLinkDto;
use App\Models\ShortLink;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ShortLinkMysqlRepository implements ShortLinkRepositoryInterface
{
    public function create(ShortLinkDto $dto): ShortLinkDto
    {
        $link = new ShortLink([
            'original_link' => $dto->originalLink,
            'short_link' => $dto->shortLink,
            'max_visits' => $dto->maxVisits,
            'visits' => $dto->visits,
            'expires_at' => $dto->expiresAt,
        ]);


        $link->saveOrFail();
        return ShortLinkDto::fromEloquent($link);
    }

    public function findByToken(string $token): ?ShortLinkDto
    {
        $link = ShortLink::where('short_link', $token)->first();
        $link?->increment('visits');
        return $link ? ShortLinkDto::fromEloquent($link) : null;
    }

    public function incrementClicks(string $token): void
    {
        ShortLink::where('short_link', $token)->increment('visits');
    }

    public function getIfNotExpiredOrMaxClicksReached(string $token): ?ShortLinkDto
    {
        $currentTime = Carbon::now();

        $link = ShortLink::where('short_link', $token)
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', $currentTime);
            })
            ->where(function ($query) {
                $query->where('max_visits', '=', 0)
                    ->orWhereColumn('visits', '<', 'max_visits');
            })
            ->first();

        return $link ? ShortLinkDto::fromEloquent($link) : null;
    }

}
