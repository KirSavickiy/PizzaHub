<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->productItem->id,
            'name' => $this->productItem->product->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'stock' => $this->productItem->stock,
            'dough_type' => $this->ProductItem->dough_type,
            'total_price' => round($this->price * $this->quantity, 2),
        ];
    }
}
