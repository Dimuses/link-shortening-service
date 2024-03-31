<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\ShortLinkDto;
use App\Repositories\ShortLinkRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ShortLinkService
{

    public function __construct(
        protected ShortLinkRepositoryInterface $shortLinkRepository
    ){}

    public function createShortLink(array $data): ShortLinkDto
    {
        $shortLink = $this->generateToken();
        $expiresAt = isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : now()->addDay();
        return $this->shortLinkRepository->create(new ShortLinkDto(
            $data['original_link'],
            $shortLink,
            (int)$data['max_visits'] ?? 0,
            $expiresAt,
        ));
    }

    public function getAndRedirect(string $token): ?string
    {
        /** @var ShortLinkDto $shortLink */
        $shortLink = $this->shortLinkRepository->getIfNotExpiredOrMaxClicksReached($token);
        $this->shortLinkRepository->incrementClicks($token);

        return $shortLink?->originalLink;
    }

    private function generateToken($length = 8): string
    {
        $numerals = '0123456789';
        $lowerCaseLetters = 'abcdefghijklmnopqrstuvwxyz';
        $upperCaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token = $numerals[rand(0, 9)]
            . $lowerCaseLetters[rand(0, 25)]
            . $upperCaseLetters[rand(0, 25)];

        $allCharacters = $numerals . $lowerCaseLetters . $upperCaseLetters;
        for ($i = 3; $i < $length; $i++) {
            $token .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }
        return str_shuffle($token);
    }
}
