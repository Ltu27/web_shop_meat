<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\ShowProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quantity' => $this->quantity,
            'price' => $this->price,
            'product' => new ShowProductResource($this->product),
        ];
    }
}
