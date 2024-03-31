<?php

namespace Database\Factories;

use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShortLinkFactory extends Factory
{
    protected $model = ShortLink::class;

    public function definition(): array
    {
        return [
            'original_link' => $this->faker->url,
            'short_link' => Str::random(8),
            'max_visits' => 10,
            'visits' => 0,
            'expires_at' => now()->addDays(1),
        ];
    }
}
