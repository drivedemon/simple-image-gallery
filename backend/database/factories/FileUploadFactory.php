<?php

namespace Database\Factories;

use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileUploadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FileUpload::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'file_path' => "/storage/{$user->id}/{$this->faker->name}.jpg",
            'file_name' => "{$this->faker->name}.jpg",
            'file_extension' => 'jpg',
            'file_size' => 65917,
            'file_type' => 'image/jpeg',
        ];
    }
}
