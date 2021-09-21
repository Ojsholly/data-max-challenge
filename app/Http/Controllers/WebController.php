<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $url = Request::create("/api/books", 'GET')->fullUrlWithQuery([
            'search' => ''
        ]);

        $request = Request::create($url, "GET");

        $books = call($request);

        return view('index', ['books' => $books->data]);
    }

    public function edit(int $id): View
    {
        $request = Request::create("/api/books/$id", "GET");

        $book = call($request);

        abort_unless($book->status_code == 200, $book->status_code, $book->message);

        return view('edit', ['book' => $book->data]);
    }
}