<div
    id="sale-{{ $sale->id }}"
    hx-swap-oob="outerHTML"
    @class([
        "grid gap-3 p-4 grid-cols-[90px_50px_1fr_40px_40px] text-dark items-center",
        "line-through *:opacity-40" => $sale->trashed(),
    ])
>
    <div class="font-bold text-dark">
        {!! str_replace(['(', ')'], ['<br/><span class="text-xs text-gray">', '</span>'], $sale->product->name) !!}
    </div>
    <div class="font-bold text-right text-red">{{ $sale->product->price / 100 }} €</div>
    <div class="text-gray text-right whitespace-nowrap overflow-hidden text-ellipsis">{{ $sale->author }}</div>
    <div>{{ $sale->created_at->isoFormat('HH:mm') }}</div>
    @can('delete', $sale)
        @if($sale->trashed())
            <button
                hx-disabled-elt="this"
                hx-post="{{ route('sale.restore', ['sale' => $sale->id]) }}"
                hx-indicator="#spinner"
                class="cursor-pointer flex self-stretch items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 disabled:opacity-30">
                <x-icon.undo class="size-5"/>
            </button>
        @else
            <button
                hx-disabled-elt="this"
                hx-delete="{{ route('sale.show', ['sale' => $sale->id]) }}"
                hx-indicator="#spinner"
                class="cursor-pointer flex self-stretch items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 disabled:opacity-30">
                <x-icon.trash class="size-5"/>
            </button>
        @endif
    @else
        <button disabled class="flex self-stretch items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 text-dark/30">
            <x-icon.trash class="size-5"/>
        </button>
    @endif
</div>
