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
                    class="disabled:opacity-30 bg-white cursor-pointer aspect-square border-gray-200 border rounded-xl flex flex-col items-center justify-center gap-4"
                >

                    <x-dynamic-component :component="sprintf('%s-line', $product->icon)" class="size-16 text-slate-400 block"/>

                    <h2 class="text-xl font-semibold text-slate-700">
                        {{ $product->name }}
                    </h2>

                </button>
            @endforeach
        </section>
    </main>
@endsection
