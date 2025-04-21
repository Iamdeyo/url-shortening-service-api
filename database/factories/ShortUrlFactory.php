<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    public function definition(): array
    {
        return [
            'url' => $this->faker->url() . '/' . $this->faker->slug(3),
            'short_code' => $this->faker->unique()->regexify('[A-Za-z0-9]{6}'),
            'access_count' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
