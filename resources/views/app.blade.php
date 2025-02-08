<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Suivi des ventes</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,500,600&display=swap" rel="stylesheet"/>
    <script>
        window.username = "{{ Auth::user()->username }}";
        window.products = {!! \App\Models\Product::all()->toJson() !!};
    </script>
    @viteReactRefresh
    @vite(['resources/js/app.tsx'])
</head>
<body class="bg-slate-100 text-dark">
    <div id="app"></div>
</body>
</html>
