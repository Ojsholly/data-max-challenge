<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class APITest extends TestCase
{
    use WithoutMiddleware, WithFaker;

    public function test_book_creation()
    {
        $data = [
            'name' => $this->faker->sentence(),
            'isbn' => $this->faker->isbn13(),
            'authors' => [$this->faker->name(), $this->faker->name()],
            'number_of_pages' => $this->faker->numberBetween(0, 1000),
            'publisher' => $this->faker->company(),
            'country' => $this->faker->country(),
            'release_date' => $this->faker->date()
        ];

        $response = $this->post('api/books', $data);

        $response->assertStatus(201);
    }

    public function test_book_update()
    {
        $data = [
            'name' => $this->faker->sentence(),
            'isbn' => $this->faker->isbn13(),
            'authors' => [$this->faker->name(), $this->faker->name()],
            'number_of_pages' => $this->faker->numberBetween(0, 1000),
            'publisher' => $this->faker->company(),
            'country' => $this->faker->country(),
            'release_date' => $this->faker->date()
        ];

        $id = Book::pluck('id')->max();

        $response = $this->patch("api/books/" . $id, $data);

        $response->assertStatus(200);
    }

    public function test_book_deletion()
    {
        $id = Book::pluck('id')->max();

        $response = $this->delete("api/books/" . $id);

        $response->assertStatus(200);
    }

    public function test_book_fetch()
    {
        $id = Book::pluck('id')->random();

        $response = $this->get("api/books/" . $id);

        $response->assertStatus(200);
    }
}