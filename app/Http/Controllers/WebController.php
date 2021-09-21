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

        $books = Route::dispatch($request)->getData();

        $books = collect($books->data);

        return view('index', ['books' => $books]);
    }

    public function edit(int $id): View
    {
        $request = Request::create("/api/books/$id", "GET");

        $book = Route::dispatch($request);

        return view('edit', ['book' => $book->getData()]);
    }
}