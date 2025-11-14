<x-guest-layout>
    @if (session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold uppercase tracking-[0.25em]">Verifique os dados informados:</p>
            <ul class="mt-2 space-y-1 pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-600">
                Email
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="admin@andrecarros.com"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200"
            >
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-600">
                    Senha
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[0.65rem] font-semibold uppercase tracking-[0.25em] text-indigo-600 hover:text-indigo-500">
                        Esqueci a senha
                    </a>
                @endif
            </div>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Digite sua senha"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200"
            >
        </div>

        <div class="flex items-center justify-between text-[0.65rem] uppercase tracking-[0.25em] text-slate-500">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                >
                <span>Lembrar acesso</span>
            </label>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-500">
                Voltar ao site
            </a>
        </div>

        <button type="submit" class="page-button w-full justify-center">
            Entrar no painel
        </button>
    </form>

    <p class="pt-6 text-center text-[0.65rem] uppercase tracking-[0.25em] text-slate-400">
        Acesso exclusivo de administradores
    </p>
</x-guest-layout>
