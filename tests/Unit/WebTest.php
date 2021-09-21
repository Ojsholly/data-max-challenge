<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class WebTest extends TestCase
{
    use WithoutMiddleware;

    public function test_index_page()
    {
        $response = $this->get('/index');

        $response->assertStatus(200);
    }

    public function test_edit_page()
    {

        $book = Book::factory()->count(1)->make();

        $book = Book::first();

        $response = $this->get('/edit/' . $book->id);

        $response->assertStatus(200);
    }
}