<div @class([
    "p-4 flex justify-between items-center gap-4 text-lg starting:translate-y-10 starting:opacity-0 starting:max-h-0  duration-700 ease-in-out translate-y-0 hidden:opacity-0 hidden:translate-y-10 border-t-2 border-t-black",
    "bg-green" => $type === "success",
    "bg-red" => $type === "error",
]) remove-me="5s" hx-ext="remove-me">
    <p>{!! $message !!}</p>
    @if(isset($action))
    <button
        hx-indicator="#spinner"
        hx-post="{{ $action['url'] }}"
        hx-trigger="click"
        hx-target="#notification"
        hx-swap="outerhtml"
        class="border border-current rounded-sm px-3 py-2">
        {{ $action['label'] }}
    </button>
    @endif
</div>
