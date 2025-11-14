<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Editar marca</h1>
                <p class="mt-1 text-sm text-gray-500">Atualize os dados da marca selecionada.</p>
            </div>
            <a href="{{ route('admin.brands.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                &larr; Voltar para lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <form method="POST" action="{{ route('admin.brands.update', $brand) }}" class="space-y-6 rounded-2xl bg-white p-8 shadow ring-1 ring-gray-200">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Nome da marca" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $brand->name) }}" required autofocus />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.brands.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <x-primary-button>
                        Atualizar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
