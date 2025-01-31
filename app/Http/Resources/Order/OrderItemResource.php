<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class OrderItemResource extends JsonResource
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
            'name' => $this->productItem->product->name,
            'size' => $this->productItem->size,
            'dough_type' => $this->productItem->dough_type,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
