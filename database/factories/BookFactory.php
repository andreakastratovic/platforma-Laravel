<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'name'=>$this->faker->name(),
           'author'=>$this->faker->author(),
           'releaseYear'=>$this->faker->releaseYear(),
           'user_id'=>User::factory(),
           'genrename'=>Genre::factory(),
        ];
    }
}
