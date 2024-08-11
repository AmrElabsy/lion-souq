<?php

namespace App\Http\Resources;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image?->path ? asset( $this->image?->path) : "",
            'images' => new ProductImageCollection($this->images),
            'tags' => new TagCollection($this->tags),
            'rating' => $this->rating,
            'comments' => new CommentCollection($this->comments),
            'vendor' => [
                'id' => $this->vendor->id,
                'name' => $this->vendor->name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],

        ];
    }
}
