<div @class([
    "p-4 flex justify-between items-center gap-4 text-lg starting:translate-y-10 starting:opacity-0 starting:max-h-0  duration-700 ease-in-out translate-y-0 hidden:opacity-0 hidden:translate-y-10",
    "bg-green-50 text-green-700" => $type === "success",
    "bg-red-50 text-red-700" => $type === "error",
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
