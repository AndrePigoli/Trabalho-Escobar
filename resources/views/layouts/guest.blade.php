<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'andreCarros') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-900">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col lg:flex-row lg:rounded-3xl lg:border lg:border-slate-200 lg:bg-white lg:shadow">
            <aside class="hidden flex-1 flex-col justify-between border-b border-slate-200 bg-slate-50 px-10 py-12 lg:flex lg:border-b-0 lg:border-r">
                <div class="space-y-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-600">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white">
                            AC
                        </span>
                        andre<span class="text-slate-900">carros</span>
                    </a>

                    <div class="space-y-4">
                        <h1 class="text-3xl font-semibold text-slate-900">
                            Painel simples para manter o catalogo sempre atualizado.
                        </h1>
                        <p class="text-sm text-slate-600">
                            Controle anuncios, marcas, modelos e cores de forma direta. Tudo o que aparecer aqui chega instantaneamente ao site publico.
                        </p>
                    </div>
                </div>

                <ul class="space-y-3 text-sm text-slate-600">
                    <li>• Cadastro completo de veiculos com links de fotos.</li>
                    <li>• Historico padrao com marcas, modelos e cores.</li>
                    <li>• Autenticacao segura para administradores.</li>
                </ul>

                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">
                    suporte: contato@andrecarros.com
                </p>
            </aside>

            <main class="flex w-full flex-1 items-center justify-center px-6 py-12">
                <div class="w-full max-w-md space-y-6 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="text-center">
                        <span class="page-pill">Acesso restrito</span>
                        <h2 class="mt-4 text-2xl font-semibold text-slate-900">Bem-vindo de volta</h2>
                        <p class="mt-2 text-sm text-slate-500">Use seu usuario administrativo para gerenciar a vitrine.</p>
                    </div>

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
