<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ServicesModel extends Model
{
    use HasFactory;
    use AsSource;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'parent_id',
        'sort',
        'user_show'
    ];

    public function getName($parentID)
    {
        if ($parentID == 0) {
            return '';
        }
        return self::find($parentID)->name;
    }
}
