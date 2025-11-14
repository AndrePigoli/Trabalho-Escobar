<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'andreCarros')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-900">
        <div class="flex min-h-screen flex-col">
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-indigo-600 text-white">
                <div class="page-shell flex flex-wrap items-center justify-between gap-3 py-3 text-[0.65rem] font-semibold uppercase tracking-[0.35em]">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                        andreCarros 2.0 pronto para agendamentos digitais
                    </span>
                    <span class="text-white/80">Atendimento imediato via WhatsApp (11) 98888-2025</span>
                </div>
            </div>

            <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="page-shell flex flex-wrap items-center justify-between gap-4 py-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-semibold uppercase tracking-[0.25em] text-indigo-600">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
                            AC
                        </span>
                        <div class="leading-tight">
                            <span class="block text-slate-900">andre<span class="font-bold text-indigo-600">carros</span></span>
                            <span class="text-[0.6rem] font-semibold uppercase tracking-[0.35em] text-slate-400">seminovos digitais</span>
                        </div>
                    </a>

                    <nav class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-600">
                        <a href="{{ route('home') }}" class="page-pill @if(request()->routeIs('home')) border-indigo-400 text-indigo-600 @endif">
                            Catalogo
                        </a>
                        <a href="{{ route('home') }}#diferenciais" class="page-pill">
                            Diferenciais
                        </a>
                        <a href="{{ route('home') }}#contato" class="page-pill">
                            Contato
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="page-pill border-indigo-400 text-indigo-600">
                                Area administrativa
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="page-button text-[0.6rem]">
                                Entrar
                            </a>
                        @endauth
                    </nav>
                </div>
            </header>

            @hasSection('hero')
                <section class="border-b border-slate-200 bg-white py-12">
                    <div class="page-shell">
                        @yield('hero')
                    </div>
                </section>
            @endif

            <main class="flex-1 py-10">
                <div class="page-shell">
                    @yield('content')
                </div>
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="page-shell flex flex-col gap-2 py-6 text-xs uppercase tracking-[0.25em] text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                    <p>&copy; {{ now()->year }} andre<span class="text-indigo-500">carros</span>. Todos os direitos reservados.</p>
                    <p>Foco em experiencia digital automotiva.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
