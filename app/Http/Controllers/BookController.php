<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Book\BookResource;
use App\Exceptions\BookNotCreatedException;
use App\Http\Requests\Book\StoreBookRequest;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{

    public function __construct(BookService $BookService)
    {
        $this->BookService = $BookService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        try {
            $book = DB::transaction(function () use ($request) {
                $record = $this->BookService->store($request->validated());

                return $record;
            });

            $data = ["book" => new BookResource($book)];

            return response()->success($data, 201);
        } catch (BookNotCreatedException | Exception $exception) {
            report($exception);

            return response()->error('Error creating new book');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}