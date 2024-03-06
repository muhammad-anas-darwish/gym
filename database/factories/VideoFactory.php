<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            // TODO add video and thumbnail photo
            // 'thumbnail_photo_path' => fake()->image(public_path('images/videos'),640,480, null, false),
            // 'video_path' => UploadedFile::fake()->create('sample.mp4', '1000', 'mp4'),
        ];
    }
}
