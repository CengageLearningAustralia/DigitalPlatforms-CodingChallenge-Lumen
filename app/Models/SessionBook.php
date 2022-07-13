<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class SessionBook
 * @property int id
 * @property int session_id
 * @property int book_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class SessionBook extends Model
{
    use HasFactory;

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function session(){
        return $this->belongsTo(Session::class);
    }

    /**
     * @return BelongsTo
     */
    public function book(){
        return $this->belongsTo(Book::class);
    }

}
