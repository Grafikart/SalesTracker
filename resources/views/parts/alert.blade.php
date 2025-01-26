<div
    hx-swap-oob="beforeend:#notification"
>
    <div
        hx-target="this"
        @class([
            "p-4 flex justify-between items-center gap-4 text-lg from:translate-y-10 from:opacity-0 duration-700 ease-in-out translate-y-0 border-t-2 border-t-dark",
            "bg-green" => $type === "success",
            "bg-red" => $type === "error",
        ])
        hx-ext="remove-me"
        remove-me="5s"
    >
        <p>{!! $message !!}</p>
        @if(isset($action))
            <button
                hx-indicator="#spinner"
                hx-post="{{ $action['url'] }}"
                hx-trigger="click"
                hx-disabled-elt="this"
                hx-swap="delete"
                class="btn">
                {{ $action['label'] }}
            </button>
        @endif
    </div>

</div>
