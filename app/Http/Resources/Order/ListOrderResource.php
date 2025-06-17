<?php

namespace App\Http\Resources\Order;

use App\Constants\OrderConstant;
use App\Http\Resources\Customer\ShowCustomerResource;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => OrderConstant::getLabel($this->status) ?? null,
            'created_at' => $this->created_at,
            'customer' => new ShowCustomerResource($this->customer) ?? null,
            'details' => $this->details ? OrderDetailResource::collection($this->details) : null,
            'total_price' => $this->getTotalPriceAttribute() ?? null,
            'payment_type' => $this->payment_type,
            'customer_name' => $this->customer ? $this->customer->name : null,
            'product_name' => $this->details->first()?->product?->name ?? null,
        ];
    }
}
