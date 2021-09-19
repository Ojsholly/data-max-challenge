<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "isbn" => $this->isbn,
            "authors" => $this->authors,
            "number_of_pages" => $this->number_of_pages,
            "publisher" => $this->publisher,
            "country" => $this->country,
            "release_date" => $this->release_date->format('Y-m-d')
        ];
    }
}