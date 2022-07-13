<?php

namespace App\Http\Resources;


use App\Models\Session;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SessionResource
 * @mixin Session
 */
class SessionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'start_at' => $this->start_at,
            'end' => $this->end_at,
            'books' => $this->whenLoaded('books', function () {
                return BookResource::collection($this->books);
            })
        ];
    }
}
