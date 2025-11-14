<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Novo modelo</h1>
                <p class="mt-1 text-sm text-gray-500">Associe o modelo à marca correspondente.</p>
            </div>
            <a href="{{ route('admin.models.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                &larr; Voltar para lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @include('admin.partials.status')

            <form method="POST" action="{{ route('admin.models.store') }}" class="space-y-6 rounded-2xl bg-white p-8 shadow ring-1 ring-gray-200">
                @csrf

                <div>
                    <x-input-label for="brand_id" value="Marca" />
                    <select id="brand_id" name="brand_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Selecione</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="name" value="Nome do modelo" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.models.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
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
