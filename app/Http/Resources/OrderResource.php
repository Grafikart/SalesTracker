<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Order resource
 */
class OrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'price' => $this->resource->price,
            'user' => $this->resource->user_id,
            'date' => $this->resource->created_at,
            'trashed' => $this->resource->deleted_at,
            'trashable' => \Auth::user()->can('destroy', $this->resource),
            'products' => $this->resource->products->map(fn (Product $product) => [
                'name' => $product->name,
                'icon' => $product->icon,
                'quantity' => $product->pivot->quantity,
            ])
        ];
    }
}
