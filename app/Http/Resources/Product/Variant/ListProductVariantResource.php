<?php

namespace App\Http\Resources\Product\Variant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListProductVariantResource extends JsonResource
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
            'stock_quantity' => $this->stock_quantity,
            'variant_color' => $this->variant_color,
            'variant_price' => $this->variant_price,
            'production_date' => $this->production_date,
            'expiration_date' => $this->expiration_date,
        ];
    }
}
