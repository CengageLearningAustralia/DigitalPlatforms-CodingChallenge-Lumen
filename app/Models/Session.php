<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * Class Session
 * @property int id
 * @property string name
 * @property int user_id
 * @property Carbon start_at
 * @property Carbon end_at
 * @property User user
 * @property Book[]|Collection books
 */
class Session extends Model
{
    use HasFactory;

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasManyThrough
     */
    public function books()
    {
        return $this->hasManyThrough(Book::class, SessionBook::class, 'session_id', 'id', 'id', 'book_id');
    }

}
