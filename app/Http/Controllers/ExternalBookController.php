<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ExternalBookService;
use App\Http\Resources\ExternalBook\ExternalBookResource;
use App\Http\Resources\ExternalBook\ExternalBookResourceCollection;

class ExternalBookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ExternalBookService $ExternalBookService)
    {
        try {

            $books =  $ExternalBookService->search($request->only(['name', 'page', 'pageSize']));

            return response()->success(new ExternalBookResourceCollection($books));
        } catch (Exception $exception) {
            report($exception);

            return response()->error('Unable to process request', 503);
        }
    }
}