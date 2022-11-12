<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Nav extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table = 'navi';

    protected $fillable = [
        'name',
        'parent_id',
        'active'
    ];
    protected $allowedFilters = [
        'name',
        'parent_id'
    ];

    protected $allowedSorts = [
        'id',
        'parent_id',
    ];

    public function getName($parentID)
    {
        if ($parentID == 0) {
            return '';
        }
        return self::find($parentID)->name;
    }
}
