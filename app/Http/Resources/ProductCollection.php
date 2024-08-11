<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'vendor' => [
                    'id' => $product->vendor->id,
                    'name' => $product->vendor->name,
                ],
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'image' => $product->image?->path ? asset( $product->image?->path) : "",
                'rating' => $product->rating
            ];
        })->toArray();
    }
}
