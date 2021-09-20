<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'isbn', 'authors', 'country', 'number_of_pages', 'publisher', 'release_date'
    ];

    protected $casts = [
        'authors' => 'array',
        'release_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function search(array $data): Builder
    {
        $search = static::query();

        $search->when(array_key_exists('name', $data), function ($query) use ($data) {
            return $query->where('name', 'LIKE', "%" . $data["name"] . "%");
        });

        $search->when(array_key_exists('country', $data), function ($query) use ($data) {
            return $query->where('country', $data["country"]);
        });

        $search->when(array_key_exists('publisher', $data), function ($query) use ($data) {
            return $query->where('publisher', 'LIKE', "%" . $data["publisher"] . "%");
        });

        $search->when(array_key_exists('release_date', $data), function ($query) use ($data) {
            return $query->whereYear('release_date', Carbon::parse($data["release_date"])->format('Y'));
        });

        return $search;
    }
}