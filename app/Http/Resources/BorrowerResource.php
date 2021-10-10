<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'borrow_id' => $this->id,
            'borrow_at' => $this->created_at,
            'borrow_status' => $this->latest_status,
            'book' => new BookResource($this->book),
            'borrower' => new UserResource($this->user)
        ];
    }
}
