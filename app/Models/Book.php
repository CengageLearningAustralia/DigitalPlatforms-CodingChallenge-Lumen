<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * Class Book
 * @property int id
 * @property string name
 * @property string isbn
 * @property Carbon published_at
 * @property string author
 */
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return HasManyThrough
     */
    public function books()
    {
        return $this->hasManyThrough(Session::class, SessionBook::class,
            'book_id', 'id', 'id', 'session_id');
    }
}
