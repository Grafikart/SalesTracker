<div
    id="sale-{{ $sale->id }}"
    hx-swap-oob="outerHTML"
    @class([
        "grid gap-4 p-4 grid-cols-[1fr_100px_max-content_max-content_40px] text-dark",
        "line-through *:opacity-40" => $sale->trashed(),
    ])
>
    <div class="font-bold text-slate-900 text-dark">
        {!! str_replace(['(', ')'], ['<span class="text-xs text-gray">(', ')</span>'], $sale->product->name) !!}
    </div>
    <div class="font-bold text-red">{{ $sale->product->price / 100 }} €</div>
    <div class="text-gray">{{ $sale->author }}</div>
    <div>{{ $sale->created_at->isoFormat('HH:mm') }}</div>
    @if($sale->trashed())
        <button
            hx-disabled-elt="this"
            hx-post="{{ route('sale.restore', ['sale' => $sale->id]) }}"
            hx-indicator="#spinner"
            class="flex items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 disabled:opacity-30">
            <x-icon.undo class="size-5"/>
        </button>
    @else
        <button
            hx-disabled-elt="this"
            hx-delete="{{ route('sale.show', ['sale' => $sale->id]) }}"
            hx-indicator="#spinner"
            class="flex items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 disabled:opacity-30">
            <x-icon.trash class="size-5"/>
        </button>
    @endif
</div>
