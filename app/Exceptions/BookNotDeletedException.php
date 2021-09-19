<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BookNotDeletedException extends Exception
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report($exception): void
    {
        $data = [
            'data' => $this->data,
            'stack trace' => $exception->getTrace()
        ];

        Log::debug('Error deleting book.', $data);
    }
}