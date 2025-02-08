<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Order::class);
    }

    public function rules(): array
    {
        return [
            'items' => 'array',
            'items.*.quantity' => 'required|int|gt:0',
            'items.*.id' => 'required|int|gt:0|exists:products,id',
        ];
    }

    /**
     * @return Collection<integer, array<{quantity: integer, product: Product}>>
     */
    public function items(): Collection
    {
        $items = collect($this->validated('items'));
        $ids = $items->map(fn (array $item) => $item['id']);
        $productsById = Product::whereIn('id', $ids)->get()->keyBy('id');
        return $items->map(
            fn($item) => [
                'quantity' => $item['quantity'],
                'product' => $productsById[$item['id']]
            ]
        );
    }
}
