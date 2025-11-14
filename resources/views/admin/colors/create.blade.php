<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Nova cor</h1>
                <p class="mt-1 text-sm text-gray-500">Defina um nome e, opcionalmente, um código hexadecimal.</p>
            </div>
            <a href="{{ route('admin.colors.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                &larr; Voltar para lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <form method="POST" action="{{ route('admin.colors.store') }}" class="space-y-6 rounded-2xl bg-white p-8 shadow ring-1 ring-gray-200">
                @csrf

                <div>
                    <x-input-label for="name" value="Nome da cor" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                </div>

                <div>
                    <x-input-label for="hex_code" value="Código hexadecimal (opcional)" />
                    <x-text-input id="hex_code" name="hex_code" type="text" class="mt-1 block w-full" value="{{ old('hex_code') }}" placeholder="#FFFFFF" />
                    <p class="mt-1 text-xs text-gray-500">Utilize o formato #RRGGBB.</p>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.colors.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <x-primary-button>
                        Salvar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
