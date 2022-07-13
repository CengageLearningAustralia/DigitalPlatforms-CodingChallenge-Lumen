<?php

namespace App\Http\Resources;


use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BookResource
 * @mixin Book
 */
class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isbn' => $this->isbn,
            'published_at' => $this->published_at,
            'author_name' => $this->author,
        ];
    }
}
