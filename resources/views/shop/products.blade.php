@extends("base")

@section("body")

    <main>

        <section class="p-4 grid grid-cols-2 gap-4">
            @foreach($products as $product)
                <button
                    hx-disabled-elt="this"
                    hx-post="{{ route('sale.store', ['product' => $product->id]) }}"
                    hx-trigger="click"
                    hx-target="#notification"
                    hx-swap="beforeend"
                    hx-indicator="#spinner"
                    class="disabled:opacity-30 py-6 px-4 cursor-pointer card flex flex-col items-center justify-between gap-4"
                >

                    <h2 class="text-xl font-semibold leading-none">
                        {!! str_replace(['(', ')'], ['<br/><span class="text-xs text-gray">', '</span>'], $product->name) !!}
                    </h2>

                    <x-dynamic-component :component="sprintf('%s-line', $product->icon)" class="size-16 flex-none block"/>

                    <div class="self-end text-orange font-semibold"><span class="text-3xl leading-none">{{ $product->price / 100 }}</span> €</div>


                </button>
            @endforeach
        </section>
    </main>
@endsection
