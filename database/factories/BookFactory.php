<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'isbn' => $this->faker->isbn13(),
            'authors' => [$this->faker->name(), $this->faker->name()],
            'number_of_pages' => $this->faker->numberBetween(0, 1000),
            'publisher' => $this->faker->company(),
            'country' => $this->faker->country(),
            'release_date' => $this->faker->date()
        ];
    }
}