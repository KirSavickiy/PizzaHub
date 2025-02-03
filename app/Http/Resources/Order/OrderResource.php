<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user->id,
            'status' => $this->statuses->sortByDesc('created_at')->first()->new_status,
            'delivery_method' =>  $this->delivery_method,
            'payment_method' => $this->payment_method,
            'delivery_time' => $this->delivery_time,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
