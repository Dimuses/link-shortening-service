<?php

namespace App\Repositories;

use App\Dto\ShortLinkDto;

interface ShortLinkRepositoryInterface
{
    /**
     * Creates a new shortened link.
     *
     * @param ShortLinkDto $dto
     * @return mixed
     */
    public function create(ShortLinkDto $dto): ShortLinkDto;

    /**
     * Finds a shortened link by its token.
     *
     * @param string $token The token of the shortened link.
     * @return ShortLinkDto|null
     */
    public function findByToken(string $token): ?ShortLinkDto;

    /**
     * Increments the click count for a shortened link.
     *
     * @param string $token The token of the shortened link.
     * @return void
     */
    public function incrementClicks(string $token): void;

    /**
     * Checks if the link has expired or the maximum number of clicks has been reached.
     *
     * @param string $token The token of the shortened link.
     * @return ShortLinkDto|null
     */
    public function getIfNotExpiredOrMaxClicksReached(string $token): ?ShortLinkDto;

}
