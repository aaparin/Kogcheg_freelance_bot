<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Places extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $table = 'places';

    protected $allowedFilters = [
        'name',
        'place_id'
    ];

    protected $allowedSorts = [
        'id',
        'parent_id',
        'sorts'
    ];

    public function getName($parentID)
    {
        if ($parentID == 0) {
            return '';
        }
        return self::find($parentID)->name;
    }
}
