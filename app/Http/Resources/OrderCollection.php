<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($order) {
            return [
                'id' => $order->id,
                'vendor' => [
                    'id' => $order->vendor->id,
                    'name' => $order->vendor->name,
                ],
                'user' => [
                    'id' => $order->user->id,
                    'name' => $order->user->name,
                ],
                'total' => $order->total,
                'status' => $order->status,
                'products' => new ProductCollection($order->products)
            ];
        })->toArray();
    }
}
