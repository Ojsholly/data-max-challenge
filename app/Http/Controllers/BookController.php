<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Book\BookResource;
use App\Exceptions\BookNotCreatedException;
use App\Exceptions\BookNotDeletedException;
use App\Exceptions\BookNotUpdatedException;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookResourceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $perPage = request()->query('perPage', 10);
        $page = request()->query('page', 1);
        $asc = request()->query('asc', true);
        $orderBy = request()->query('orderBy', 'name');

        $books = $this->BookService->search(
            request()->only(['name', 'country', 'publisher', 'release_date'])
                + ['perPage' => $perPage, 'page' => $page, 'asc' => $asc, 'orderBy' => $orderBy]
        );

        return response()->success(new BookResourceCollection($books));
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

            return response()->success($data, "", 201);
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
    public function show($id): JsonResponse
    {
        try {
            $book = $this->BookService->find(['id' => $id]);

            return response()->success(new BookResource($book));
        } catch (ModelNotFoundException $exception) {

            return response()->error('Requested book not found', 404);
        } catch (Exception $exception) {
            report($exception);

            return response()->error('Error fetching requested book');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id): JsonResponse
    {
        try {
            $book = DB::transaction(function () use ($request, $id) {

                $update = $this->BookService->update(array_filter($request->validated()), $id);

                return $update;
            });

            return response()->success(new BookResource($book), "The book $book->name, was updated successfully");
        } catch (ModelNotFoundException $exception) {

            return response()->error('Requested book not found', 404);
        } catch (BookNotUpdatedException | Exception $exception) {
            report($exception);

            return response()->error('Error updating book.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        try {
            $book = DB::transaction(function () use ($id) {

                $book = $this->BookService->find(['id' => $id]);

                $delete = $this->BookService->delete(['id' => $id]);

                return $book;
            });

            return response()->success([], "The book $book->name was deleted successfully", 204, true);
        } catch (ModelNotFoundException $exception) {

            return response()->error('Requested book not found', 404);
        } catch (BookNotDeletedException | Exception $exception) {
            report($exception);

            return response()->error('Error deleting book.', 500);
        }
    }
}