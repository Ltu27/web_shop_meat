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
            'status' => OrderConstant::getLabel($this->status),
            'created_at' => $this->created_at,
            'customer' => new ShowCustomerResource($this->customer),
            'details' => OrderDetailResource::collection($this->details),
            'total_price' => $this->getTotalPriceAttribute(),
            'payment_type' => $this->payment_type,
        ];
    }
}
