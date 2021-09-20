<?php

namespace App\Http\Controllers;

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
    public function __invoke(Request $request)
    {
        $url = Request::create("/api/books", 'GET')->fullUrlWithQuery([
            'search' => ''
        ]);

        $request = Request::create($url, "GET");

        $books = Route::dispatch($request)->getData();

        $books = collect($books->data);

        return view('index', ['books' => $books]);
    }
}