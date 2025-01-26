@extends("base")

@section("body")
    <main class="py-6 px-4">

        <h1 class="text-4xl text-center font-semibold">Se connecter</h1>

        <form method="post" action="" class="space-y-4">
            <div class="space-y-2">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" class="field">
                @error('password')
                <div class="text-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button class="btn bg-white">Se connecter</button>
        </form>

    </main>
@endsection
