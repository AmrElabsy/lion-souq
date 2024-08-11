<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'product' => [
                'id' => $this->product_id,
                'name' => $this->product->name
            ],
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name
            ],
        ];
    }
}
