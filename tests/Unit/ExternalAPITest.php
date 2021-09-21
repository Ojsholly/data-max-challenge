<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExternalAPITest extends TestCase
{
    public function test_external_book_status()
    {
        $name = "A Game of Thrones";

        $response = $this->get("/api/external-books?name=" . $name, ['accept' => 'application/json']);

        $response->assertStatus(200);
    }
}