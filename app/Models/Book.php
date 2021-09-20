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

    public static function search(string $search): Builder
    {
        return empty($search) ? static::query() :
            static::query()->where('name', 'LIKE', "%" . $search . "%")
            ->OrWhere('country', 'LIKE', "%" . $search . "%")
            ->orWhere('publisher', 'LIKE', "%" . $search . "%")
            ->when(strtotime($search), function ($query) use ($search) {
                return $query->orWhereYear('release_date', Carbon::parse($search)->format('Y'));
            });
    }
}