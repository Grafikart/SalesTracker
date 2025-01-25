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
                    class="disabled:opacity-30 py-6 px-4 bg-white cursor-pointer border-gray-200 border rounded-xl flex flex-col items-center justify-between gap-4 duration-300 hover:shadow-md"
                >

                    <h2 class="text-xl text-slate-900 font-semibold">
                        {{ $product->name }}
                    </h2>

                    <x-dynamic-component :component="sprintf('%s-line', $product->icon)" class="size-16 flex-none text-slate-400 block"/>

                    <div class="self-end text-orange-400 font-semibold"><span class="text-3xl leading-none">{{ $product->price / 100 }}</span> €</div>


                </button>
            @endforeach
        </section>
    </main>
@endsection
