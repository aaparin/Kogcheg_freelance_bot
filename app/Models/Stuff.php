<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Stuff extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $table = 'stuff';

    protected static $statuses = [
        'inactive' => 'Не активный',
        'active' => 'Активный',
        'blocked' => 'Заблокированный'
    ];

    public static function getStatuses(): array
    {
        return self::$statuses;
    }
}
