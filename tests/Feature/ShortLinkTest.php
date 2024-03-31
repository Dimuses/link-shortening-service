<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ShortLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortLinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_short_link()
    {
        $response = $this->post(route('link.create'), [
            'original_link' => 'https://example.com',
            'max_visits' => 5,
            'expires_at' => now()->addHour()->toDateTimeString(),
        ]);

        $response->assertRedirect(route('link.form'));
        $response->assertSessionHas('success');
        $this->assertCount(1, ShortLink::all());
    }

    /** @test */
    public function user_can_redirect_to_original_link_if_not_expired_and_not_reached_max_visits()
    {
        $link = ShortLink::factory()->create();
        $response = $this->get(route('link.redirect', ['shortLink' => $link->short_link]));
        $response->assertRedirect($link->original_link);

        $this->assertDatabaseHas('short_links', [
            'id' => $link->id,
            'visits' => 1,
        ]);
    }

    /** @test */
    public function user_sees_404_page_if_link_is_expired_or_reached_max_visits()
    {
        $expiredLink = ShortLink::factory()->create([
            'expires_at' => now()->subDay(),
        ]);

        $maxVisitsLink = ShortLink::factory()->create([
            'max_visits' => 5,
            'visits' => 5,
        ]);

        $responseExpired = $this->get(route('link.redirect', ['shortLink' => $expiredLink->short_link]));
        $responseExpired->assertStatus(404);

        $responseMaxVisits = $this->get(route('link.redirect', ['shortLink' => $maxVisitsLink->short_link]));
        $responseMaxVisits->assertStatus(404);
    }

    /** @test */
    public function it_fails_to_create_a_short_link_with_a_duplicate_token()
    {
        $link = ShortLink::factory()->create([
            'expires_at' => now()->addHours(2)->toDateTimeString(),
        ]);

        $secondResponse = $this->post(route('link.create'), [
            'original_link' => 'https://example.com/second',
            'short_link' => $link->short_link,
            'max_visits' => 10,
            'expires_at' => now()->addHours(5)->toDateTimeString(),
        ]);

        $secondResponse->assertSessionHasErrors('short_link');
    }
}
